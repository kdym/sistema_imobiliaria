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
        $slipsRecursiveTable = TableRegistry::get('SlipsRecursive');
        $slipsCustomValuesTable = TableRegistry::get('SlipsCustomsValues');
        $customBillsTable = TableRegistry::get('CustomBills');

        $firstSalary = new DateTime($contract['primeiro_vencimento']->format('Y-m-d'));
        $ownDate = new DateTime($contract['data_posse']->format('Y-m-d'));
        $today = new DateTime('now');

        $contractValues = $contractsValuesTable->find()
            ->where(['date_format(start_date, "%Y-%m") <=' => $date->format('Y-m')])
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
                ->where(['date_format(start_date, "%Y-%m") <=' => $date->format('Y-m')])
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

//        $recursiveRent = $slipsRecursiveTable->find()
//            ->where(['contract_id' => $contract['id']])
//            ->where(['tipo' => ContractsTable::RENT])
//            ->where(['DATE_FORMAT(:date, "%Y-%m") BETWEEN DATE_FORMAT(start_date, "%Y-%m") AND DATE_FORMAT(end_date, "%Y-%m")'])
//            ->bind(':date', $date->format('Y-m-d'))
//            ->last();
//
//        $recursion = new SlipValueRecursion();
//
//        if ($recursiveRent) {
//            $rent = $recursiveRent['valor'];
//
//            $recursion->setType($this->getRecursionInfo($recursiveRent));
//            $recursion->setStartDate(new DateTime($recursiveRent['start_date']->format('Y-m-d')));
//            $recursion->setEndDate(new DateTime($recursiveRent['end_date']->format('Y-m-d')));
//        } else {
//            $propertyPrice = $propertiesPricesTable->find()
//                ->where(['date_format(start_date, "%Y-%m") <=' => $date->format('Y-m')])
//                ->where(['property_id' => $contract['property_id']])
//                ->last();
//
//            if (!$propertyPrice) {
//                $propertyPrice = $propertiesPricesTable->find()
//                    ->where(['property_id' => $contract['property_id']])
//                    ->last();
//            }
//
//            $rent = $propertyPrice['valor'];
//
//            if ($date->format('Y-m') == $firstSalary->format('Y-m')) {
//                $diff = $ownDate->diff($firstSalary);
//
//                $rent = ($propertyPrice['valor'] * ($diff->days + 1)) / ContractsTable::DEFAULT_MONTH_DAYS;
//            }
//
//            $recursion->setType(SlipsRecursiveTable::RECURSION_ALL);
//        }

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

//        foreach (ContractsValuesTable::$generalFees as $f) {
//            if (!empty($contractValues[$f->getKey()]) && $f->getKey() <> ContractsValuesTable::CPMF) {
//                $recursiveFee = $slipsRecursiveTable->find()
//                    ->where(['contract_id' => $contract['id']])
//                    ->where(['tipo' => $f->getKey()])
//                    ->where(['DATE_FORMAT(:date, "%Y-%m") BETWEEN DATE_FORMAT(start_date, "%Y-%m") AND DATE_FORMAT(end_date, "%Y-%m")'])
//                    ->bind(':date', $date->format('Y-m-d'))
//                    ->last();
//
//                $recursion = new SlipValueRecursion();
//
//                if ($recursiveFee) {
//                    $value = $recursiveFee['valor'];
//
//                    $recursion->setType($this->getRecursionInfo($recursiveFee));
//                    $recursion->setStartDate(new DateTime($recursiveFee['start_date']->format('Y-m-d')));
//                    $recursion->setEndDate(new DateTime($recursiveFee['end_date']->format('Y-m-d')));
//                } else {
//                    $value = $f->getValue($date);
//
//                    $recursion->setType(SlipsRecursiveTable::RECURSION_ALL);
//                }
//
//                $slipValue = new SlipValue();
//
//                $slipValue->setName($f->getName());
//                $slipValue->setValue($value);
//                $slipValue->setType($f->getKey());
//                $slipValue->setRecursion($recursion);
//
//                $this->values[] = $slipValue;
//
//                $sum += $value;
//            }
//        }

        //Taxas Custom
        $customBill = $customBillsTable->find()
            ->where(['reference_id' => $contract['id']])
            ->where(['pagante' => Bills::PAYER_RECEIVER_TENANT]);

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

//        $customValues = $slipsCustomValuesTable->find()
//            ->contain('SlipsRecursive')
//            ->where(['contract_id' => $contract['id']]);
//
//        foreach ($customValues as $c) {
//            foreach ($c['slips_recursive'] as $r) {
//                $recursion = new SlipValueRecursion();
//
//                $recursion->setType($this->getRecursionInfo($r));
//                $recursion->setStartDate($r['start_date']);
//                $recursion->setEndDate($r['end_date']);
//
//                switch ($recursion->getType()) {
//                    case SlipsRecursiveTable::RECURSION_NONE:
//                        if ($date->format('Y-m') <> $recursion->getStartDate()->format('Y-m')) {
//                            continue 2;
//                        }
//
//                        break;
//
//                    case SlipsRecursiveTable::RECURSION_PERIOD:
//                        if (!($date->format('Y-m') >= $recursion->getStartDate()->format('Y-m') && $date->format('Y-m') <= $recursion->getEndDate()->format('Y-m'))) {
//                            continue 2;
//                        }
//
//                        break;
//
//                    case SlipsRecursiveTable::RECURSION_START_AT:
//                        if (!($date->format('Y-m') >= $recursion->getStartDate()->format('Y-m'))) {
//                            continue 2;
//                        }
//
//                        break;
//                }
//
//                if ($r['deleted'] == true) {
//                    break;
//                }
//
//                $slipValue = new SlipValue();
//
//                $slipValue->setName($c['descricao']);
//                $slipValue->setValue($r['valor']);
//                $slipValue->setType(ContractsTable::CUSTOM_FEE);
//                $slipValue->setRecursion($recursion);
//                $slipValue->setCustomId($c['id']);
//
//                $this->values[] = $slipValue;
//
//                break;
//            }
//        }

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

//        $paidSlipsTable = TableRegistry::get('PaidSlips');
//
//        $slipPaid = $paidSlipsTable->find()
//            ->where(['vencimento' => $this->getSalary()->format('Y-m-d')])
//            ->where(['contract_id' => $contract['id']])
//            ->first();
//
//        if ($slipPaid) {
//            $this->setStatus(self::PAID);
//            $this->setPaidDate(new DateTime($slipPaid['data_pago']->format('Y-m-d')));
//        } else {
//            $this->setPaidDate(null);
//
//            if ($today->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
//                $this->setStatus(self::LATE);
//            } else {
//                $this->setStatus(self::NORMAL);
//            }
//        }

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