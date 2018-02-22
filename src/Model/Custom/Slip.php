<?php
/**
 * Created by PhpStorm.
 * User: sKnMetal
 * Date: 12/10/2017
 * Time: 10:22
 *
 * @var \App\Model\Custom\GeneralFee $f
 */

namespace App\Model\Custom;


use App\Model\Table\ContractsTable;
use App\Model\Table\ContractsValuesTable;
use App\Model\Table\ParametersTable;
use App\Model\Table\PropertiesTable;
use App\Model\Table\SlipsRecursiveTable;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use DateTime;
use JsonSerializable;

class Slip
{
    const PAID = 'paid';
    const LATE = 'late';
    const NORMAL = 'normal';

    private $salary;
    private $contract;
    private $values;
    private $status;
    private $paidDate;

    public function __construct($contract, DateTime $date)
    {
        $this->contract = $contract;

        $contractsValuesTable = TableRegistry::get('ContractsValues');
        $propertiesPricesTable = TableRegistry::get('PropertiesPrices');
        $propertiesFeesTable = TableRegistry::get('PropertiesFees');
        $slipsRecursiveTable = TableRegistry::get('SlipsRecursive');
        $slipsCustomValuesTable = TableRegistry::get('SlipsCustomsValues');
        $customBillsTable = TableRegistry::get('CustomBills');
        $parametersTable = TableRegistry::get('Parameters');

        $firstSalary = new DateTime($contract['primeiro_vencimento']->format('Y-m-d'));
        $ownDate = new DateTime($contract['data_posse']->format('Y-m-d'));
        $today = new DateTime('now');

        $contractValues = $contractsValuesTable->find()
            ->where(['date_format(start_date, "%Y-%m") <= :date'])
            ->bind(':date', $date->format('Y-m'))
            ->where(['contract_id' => $contract['id']])
            ->last();

        if ($date->format('Y-m') == $firstSalary->format('Y-m')) {
            $this->salary = new DateTime($firstSalary->format('Y-m-d'));
        } else {
            $this->salary = new DateTime(sprintf("%s-%s", $date->format('Y-m'), $contractValues['vencimento_boleto']));
        }

        $this->contract = $contract['id'];

        $this->values = [];

        //Aluguel
        $value = 0;
        $status = Bills::OPEN;
        $transactionId = null;

        if ($billTransaction = $this->checkIfPaid(Bills::RENT, $contract['id'])) {
            $value = $billTransaction['valor'];
            $status = Bills::PAID;
            $this->paidDate = new DateTime($billTransaction['data_pago']->format('Y-m-d'));
            $transactionId = $billTransaction['id'];
        } else {
            $propertyPrice = $propertiesPricesTable->find()
                ->where(['date_format(start_date, "%Y-%m") <= :date'])
                ->bind(':date', $date->format('Y-m'))
                ->where(['property_id' => $contract['property_id']])
                ->last();

            if (!$propertyPrice) {
                $propertyPrice = $propertiesPricesTable->find()
                    ->where(['property_id' => $contract['property_id']])
                    ->last();
            }

            $value = $propertyPrice['valor'];

            if ($date->format('Y-m') == $firstSalary->format('Y-m')) {
                $diff = $ownDate->diff($firstSalary);

                $value = ($propertyPrice['valor'] * ($diff->days + 1)) / ContractsTable::DEFAULT_MONTH_DAYS;
            }

            if ($today->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
                $status = Bills::LATE;
            }
        }

        $sum = 0;

        $slipValue = new SlipValue();

        $slipValue->setName(Bills::$bills[Bills::RENT]);
        $slipValue->setValue($value);
        $slipValue->setType(Bills::RENT);
        $slipValue->setStatus($status);
        $slipValue->setTransactionId($transactionId);

        $this->values[] = $slipValue;

        $sum += $value;

        //Taxas Extras
        foreach (ContractsValuesTable::$generalFees as $f) {
            if (!empty($contractValues[$f->getKey()]) && $f->getKey() <> ContractsValuesTable::CPMF) {
                $value = 0;
                $status = Bills::OPEN;
                $transactionId = null;
                if ($billTransaction = $this->checkIfPaid($f->getKey(), $contract['id'])) {
                    $value = $billTransaction['valor'];
                    $status = Bills::PAID;
                    $this->paidDate = new DateTime($billTransaction['data_pago']->format('Y-m-d'));
                    $transactionId = $billTransaction['id'];
                } else {
                    $value = $f->getValue($date);

                    if ($today->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
                        $status = Bills::LATE;
                    }
                }

                $slipValue = new SlipValue();

                $slipValue->setName($f->getName());
                $slipValue->setValue($value);
                $slipValue->setType($f->getKey());
                $slipValue->setStatus($status);
                $slipValue->setTransactionId($transactionId);

                $this->values[] = $slipValue;

                $sum += $value;
            }
        }

        $categoryPropertiesBills = [];
        foreach (PropertiesTable::$propertiesBills as $key => $b) {
            $categoryPropertiesBills[] = $key;
        }

        foreach (PropertiesTable::$diferenceBills as $key => $b) {
            $categoryPropertiesBills[] = $key;
        }

        //Taxas Custom
        $customBill = $customBillsTable->find()
            ->where(['reference_id' => $contract['id']])
            ->where(['pagante' => Bills::PAYER_RECEIVER_TENANT])
            ->where(['categoria not in' => $categoryPropertiesBills]);

        foreach ($customBill as $c) {
            $value = 0;
            $status = Bills::OPEN;
            $transactionId = null;

            if ($billTransaction = $this->checkIfPaid($c['categoria'], $contract['id'])) {
                $value = $billTransaction['valor'];
                $status = Bills::PAID;
                $this->paidDate = new DateTime($billTransaction['data_pago']->format('Y-m-d'));
                $transactionId = $billTransaction['id'];
            } else {
                $value = $c['valor'];

                if ($today->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
                    $status = Bills::LATE;
                }
            }

            $slipValue = new SlipValue();

            $slipValue->setName(sprintf('%s (%s)', $c['descricao'], Bills::$bills[$c['categoria']]));
            $slipValue->setValue($value);
            $slipValue->setType($c['categoria']);
            $slipValue->setStatus($status);
            $slipValue->setTransactionId($transactionId);

            $recursivity = new Recursivity($c);

            if (!empty($c['data_inicio'])) {
                $startDate = new DateTime($c['data_inicio']->format('Y-m-d'));
            }

            if (!empty($c['data_fim'])) {
                $endDate = new DateTime($c['data_fim']->format('Y-m-d'));
            }

            switch ($recursivity->getType()) {
                case Recursivity::RECURSIVITY_ALWAYS:
                    $this->values[] = $slipValue;

                    $sum += $value;

                    break;

                case Recursivity::RECURSION_NONE:
                    if ($this->getSalary()->format('Y-m') == $startDate->format('Y-m')) {
                        $this->values[] = $slipValue;

                        $sum += $value;
                    }

                    break;

                case Recursivity::RECURSION_START_AT:
                    if ($this->getSalary()->format('Y-m') >= $startDate->format('Y-m')) {
                        $this->values[] = $slipValue;

                        $sum += $value;
                    }

                    break;

                case Recursivity::RECURSION_PERIOD:
                    if (
                        $this->getSalary()->format('Y-m') >= $startDate->format('Y-m') &&
                        $this->getSalary()->format('Y-m') <= $endDate->format('Y-m')
                    ) {
                        $this->values[] = $slipValue;

                        $sum += $value;
                    }

                    break;
            }
        }

        $propertyFees = $propertiesFeesTable->find()
            ->where(['date_format(start_date, "%Y-%m") <= :date'])
            ->bind(':date', $date->format('Y-m'))
            ->where(['property_id' => $contract['property_id']])
            ->last();

        //Contas do Imóvel
        foreach (PropertiesTable::$propertiesBills as $key => $b) {
            if (empty($propertyFees[$key])) {
                break;
            }

            $slipValue = new SlipValue();

            $slipValue->setType($key);

            $isPosted = $customBillsTable->find()
                ->where(['reference_id' => $contract['id']])
                ->where(['pagante' => Bills::PAYER_RECEIVER_TENANT])
                ->where(['categoria' => $key])
                ->where(['date_format(data_inicio, "%Y-%m") = :date'])
                ->bind(':date', $date->format('Y-m'))
                ->first();

            if ($isPosted) {
                $slipValue->setValue($isPosted['valor']);
                $slipValue->setStatus(Bills::OPEN);
                $slipValue->setName(sprintf('%s (%s)', $isPosted['descricao'], $b));

                if ($billTransaction = $this->checkIfPaid($key, $contract['id'])) {
                    $slipValue->setValue($billTransaction['valor']);
                    $slipValue->setStatus(Bills::PAID);
                    $slipValue->setTransactionId($billTransaction['id']);

                    $this->paidDate = new DateTime($billTransaction['data_pago']->format('Y-m-d'));
                } else {
                    if ($today->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
                        $slipValue->setStatus(Bills::LATE);
                    }
                }

                $this->values[] = $slipValue;

                $sum += $slipValue->getValue();
            } else {
                $diff = $today->diff($this->getSalary());

                if ($diff->invert == true || ($diff->invert == false && $diff->days <= 5)) {
                    $lastMonth = new DateTime($this->getSalary()->format('Y-m-d'));
                    $lastMonth->modify('-1 month');

                    $isPosted = $customBillsTable->find()
                        ->where(['reference_id' => $contract['id']])
                        ->where(['pagante' => Bills::PAYER_RECEIVER_TENANT])
                        ->where(['categoria' => $key])
                        ->where(['date_format(data_inicio, "%Y-%m") = :date'])
                        ->bind(':date', $lastMonth->format('Y-m'))
                        ->first();

                    $slipValue->setStatus(Bills::OPEN);
                    $slipValue->setName(sprintf('%s (%s)', $isPosted['descricao'], $b));

                    if (
                        $diff->invert == true &&
                        $today->format('Y-m-d') <> $this->getSalary()->format('Y-m-d')
                    ) {
                        $slipValue->setStatus(Bills::LATE);
                    }

                    if ($isPosted) {
                        $slipValue->setValue($isPosted['valor']);

                        $this->values[] = $slipValue;

                        $sum += $slipValue->getValue();
                    } else {
                        $minValue = 0;
                        $parameter = null;

                        switch ($key) {
                            case PropertiesTable::BILL_WATER:
                                switch ($propertyFees['imovel_tipo']) {
                                    case PropertiesTable::TYPE_RESIDENTIAL:
                                        $parameter = ParametersTable::MIN_WATER_RESIDENTIAL;

                                        break;

                                    case PropertiesTable::TYPE_NON_RESIDENTIAL:
                                        $parameter = ParametersTable::MIN_WATER_NON_RESIDENTIAL;

                                        break;
                                }

                                break;
                        }

                        $query = $parametersTable->find()
                            ->where(['nome' => $parameter])
                            ->where(['date_format(start_date, "%Y-%m") = :date'])
                            ->bind(':date', $this->getSalary()->format('Y-m'))
                            ->last();

                        if ($query) {
                            $minValue = $query['valor'];
                        }

                        $slipValue->setValue($minValue);
                        $slipValue->setName(sprintf('Conta do Imóvel (%s)', $b));

                        $this->values[] = $slipValue;

                        $sum += $slipValue->getValue();
                    }
                }
            }
        }

        //Diferenças de Contas
        foreach (PropertiesTable::$diferenceBills as $key => $b) {
            $slipValue = new SlipValue();

            $slipValue->setType($key);

            $isPosted = $customBillsTable->find()
                ->where(['reference_id' => $contract['id']])
                ->where(['pagante' => Bills::PAYER_RECEIVER_TENANT])
                ->where(['categoria' => $key])
                ->where(['date_format(data_inicio, "%Y-%m") = :date'])
                ->bind(':date', $date->format('Y-m'))
                ->first();

            if ($isPosted) {
                $slipValue->setValue($isPosted['valor']);
                $slipValue->setStatus(Bills::OPEN);
                $slipValue->setName(sprintf('Diferença Mês Anterior (%s)', $b));

                if ($billTransaction = $this->checkIfPaid($key, $contract['id'])) {
                    $slipValue->setValue($billTransaction['valor']);
                    $slipValue->setStatus(Bills::PAID);
                    $slipValue->setTransactionId($billTransaction['id']);

                    $this->paidDate = new DateTime($billTransaction['data_pago']->format('Y-m-d'));
                } else {
                    if ($today->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
                        $slipValue->setStatus(Bills::LATE);
                    }
                }

                $this->values[] = $slipValue;

                $sum += $slipValue->getValue();
            }
        }

        //Status do Boleto
        $this->setStatus(self::NORMAL);

        foreach ($this->values as $v) {
            if ($v->getStatus() == Bills::LATE) {
                $this->setStatus(self::LATE);

                break;
            }

            if ($v->getStatus() == Bills::PAID) {
                $this->setStatus(self::PAID);

                break;
            }
        }

        //Desconto/Multa
        $isFee = false;
        $isDiscount = false;

        if ($this->getStatus() == self::LATE) {
            $isFee = true;
        }

        if ($this->getStatus() == self::PAID) {
            if ($this->getPaidDate()->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
                $isFee = true;
            } else {
                $isDiscount = true;
            }
        } else {
            if ($today->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
                $isFee = true;
            } else {
                $isDiscount = true;
            }
        }

        if ($isFee) {
            if (!empty($contractValues['multa'])) {
                $value = 0;
                $transactionId = null;

                if ($billTransaction = $this->checkIfPaid(Bills::FINE_CONTRACT, $contract['id'])) {
                    $value = $billTransaction['valor'];
                    $this->paidDate = new DateTime($billTransaction['data_pago']->format('Y-m-d'));
                    $transactionId = $billTransaction['id'];
                } else {
                    $value = ($sum * $contractValues['multa']) / 100;
                }

                $slipValue = new SlipValue();

                $slipValue->setName(Bills::$bills[Bills::FINE_CONTRACT]);
                $slipValue->setValue($value);
                $slipValue->setType(Bills::FINE_CONTRACT);
                $slipValue->setTransactionId($transactionId);

                $this->values[] = $slipValue;
            }
        }

        if ($isDiscount) {
            if (!empty($contractValues['desconto'])) {
                $value = 0;
                $transactionId = null;

                if ($billTransaction = $this->checkIfPaid(Bills::DISCOUNT_CONTRACT, $contract['id'])) {
                    $value = $billTransaction['valor'];
                    $this->paidDate = new DateTime($billTransaction['data_pago']->format('Y-m-d'));
                    $transactionId = $billTransaction['id'];
                } else {
                    $value = (($sum * $contractValues['desconto']) / 100) * -1;
                }

                $slipValue = new SlipValue();

                $slipValue->setName(Bills::$bills[Bills::DISCOUNT_CONTRACT]);
                $slipValue->setValue($value);
                $slipValue->setType(Bills::DISCOUNT_CONTRACT);
                $slipValue->setTransactionId($transactionId);

                $this->values[] = $slipValue;
            }
        }

        usort($this->values, [$this, 'cmp']);
    }

    public function checkIfPaid($key, $reference)
    {
        $billsTransactionsTable = TableRegistry::get('BillsTransactions');

        return $billsTransactionsTable->find()
            ->where(['reference_id' => $reference])
            ->where(['categoria' => $key])
            ->where(['DATE_FORMAT(data_vencimento, "%Y-%m") = :date'])
            ->bind(':date', $this->getSalary()->format('Y-m'))
            ->last();
    }

    function cmp($a, $b)
    {
        return strcmp($a->getName(), $b->getName());
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function getValues()
    {
        return $this->values;
    }

    private function getRecursionInfo($recursion)
    {
        if (!empty($recursion['start_date']) && !empty($recursion['end_date'])) {
            if ($recursion['start_date']->format('Y-m') == $recursion['end_date']->format('Y-m')) {
                return SlipsRecursiveTable::RECURSION_NONE;
            } else {
                return SlipsRecursiveTable::RECURSION_PERIOD;
            }
        }

        if (!empty($recursion['start_date']) && empty($recursion['end_date'])) {
            return SlipsRecursiveTable::RECURSION_START_AT;
        }

        if (empty($recursion['start_date']) && empty($recursion['end_date'])) {
            return SlipsRecursiveTable::RECURSION_ALL;
        }
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return null
     */
    public function getPaidDate()
    {
        return $this->paidDate;
    }

    /**
     * @param null $paidDate
     */
    public function setPaidDate($paidDate)
    {
        $this->paidDate = $paidDate;
    }

    /**
     * @return mixed
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * @param mixed $contract
     */
    public function setContract($contract)
    {
        $this->contract = $contract;
    }

    public function toJSON()
    {
        $data = [
            'salary' => $this->getSalary()->format('Y-m-d'),
            'contract' => $this->getContract(),
            'values' => []
        ];

        /* @var SlipValue $v */
        foreach ($this->getValues() as $v) {
            $data['values'][] = [
                'category' => $v->getType(),
                'value' => $v->getValue(),
                'transaction_id' => $v->getTransactionId(),
            ];
        }

        return json_encode($data);
    }
}