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

        $firstSalary = new DateTime($contract['primeiro_vencimento']->format('Y-m-d'));
        $ownDate = new DateTime($contract['data_posse']->format('Y-m-d'));

        $contractValues = $contractsValuesTable->find()
            ->where(['date_format(start_date, "%Y-%m") <=' => $date->format('Y-m')])
            ->where(['contract_id' => $contract['id']])
            ->last();

        if ($date->format('Y-m') == $firstSalary->format('Y-m')) {
            $this->salary = new DateTime($firstSalary->format('Y-m-d'));
        } else {
            $this->salary = new DateTime(sprintf("%s-%s", $date->format('Y-m'), $contractValues['vencimento_boleto']));
        }

        $this->values = [];

        //Aluguel
        $recursiveRent = $slipsRecursiveTable->find()
            ->where(['contract_id' => $contract['id']])
            ->where(['tipo' => ContractsTable::RENT])
            ->where(['DATE_FORMAT(:date, "%Y-%m") BETWEEN DATE_FORMAT(start_date, "%Y-%m") AND DATE_FORMAT(end_date, "%Y-%m")'])
            ->bind(':date', $date->format('Y-m-d'))
            ->last();

        $recursion = new SlipValueRecursion();

        if ($recursiveRent) {
            $rent = $recursiveRent['valor'];

            $recursion->setType($this->getRecursionInfo($recursiveRent));
            $recursion->setStartDate(new DateTime($recursiveRent['start_date']->format('Y-m-d')));
            $recursion->setEndDate(new DateTime($recursiveRent['end_date']->format('Y-m-d')));
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

            $rent = $propertyPrice['valor'];

            if ($date->format('Y-m') == $firstSalary->format('Y-m')) {
                $diff = $ownDate->diff($firstSalary);

                $rent = ($propertyPrice['valor'] * ($diff->days + 1)) / ContractsTable::DEFAULT_MONTH_DAYS;
            }

            $recursion->setType(SlipsRecursiveTable::RECURSION_ALL);
        }

        $sum = 0;

        $slipValue = new SlipValue();

        $slipValue->setName(ContractsTable::$feesNames[ContractsTable::RENT]);
        $slipValue->setValue($rent);
        $slipValue->setType(ContractsTable::RENT);
        $slipValue->setRecursion($recursion);

        $this->values[] = $slipValue;

        $sum += $rent;

        //Taxas Extras
        foreach (ContractsValuesTable::$generalFees as $f) {
            if (!empty($contractValues[$f->getKey()]) && $f->getKey() <> ContractsValuesTable::CPMF) {
                $recursiveFee = $slipsRecursiveTable->find()
                    ->where(['contract_id' => $contract['id']])
                    ->where(['tipo' => $f->getKey()])
                    ->where(['DATE_FORMAT(:date, "%Y-%m") BETWEEN DATE_FORMAT(start_date, "%Y-%m") AND DATE_FORMAT(end_date, "%Y-%m")'])
                    ->bind(':date', $date->format('Y-m-d'))
                    ->last();

                $recursion = new SlipValueRecursion();

                if ($recursiveFee) {
                    $value = $recursiveFee['valor'];

                    $recursion->setType($this->getRecursionInfo($recursiveFee));
                    $recursion->setStartDate(new DateTime($recursiveFee['start_date']->format('Y-m-d')));
                    $recursion->setEndDate(new DateTime($recursiveFee['end_date']->format('Y-m-d')));
                } else {
                    $value = $f->getValue($date);

                    $recursion->setType(SlipsRecursiveTable::RECURSION_ALL);
                }

                $slipValue = new SlipValue();

                $slipValue->setName($f->getName());
                $slipValue->setValue($value);
                $slipValue->setType($f->getKey());
                $slipValue->setRecursion($recursion);

                $this->values[] = $slipValue;

                $sum += $value;
            }
        }

        $today = new DateTime('now');

        //Taxas Custom
        $customValues = $slipsCustomValuesTable->find()
            ->contain('SlipsRecursive')
            ->where(['contract_id' => $contract['id']]);

        foreach ($customValues as $c) {
            foreach ($c['slips_recursive'] as $r) {
                $recursion = new SlipValueRecursion();

                $recursion->setType($this->getRecursionInfo($r));
                $recursion->setStartDate($r['start_date']);
                $recursion->setEndDate($r['end_date']);

                switch ($recursion->getType()) {
                    case SlipsRecursiveTable::RECURSION_NONE:
                        if ($date->format('Y-m') <> $recursion->getStartDate()->format('Y-m')) {
                            continue 2;
                        }

                        break;

                    case SlipsRecursiveTable::RECURSION_PERIOD:
                        if (!($date->format('Y-m') >= $recursion->getStartDate()->format('Y-m') && $date->format('Y-m') <= $recursion->getEndDate()->format('Y-m'))) {
                            continue 2;
                        }

                        break;

                    case SlipsRecursiveTable::RECURSION_START_AT:
                        if (!($date->format('Y-m') >= $recursion->getStartDate()->format('Y-m'))) {
                            continue 2;
                        }

                        break;
                }

                if ($r['deleted'] == true) {
                    break;
                }

                $slipValue = new SlipValue();

                $slipValue->setName($c['descricao']);
                $slipValue->setValue($r['valor']);
                $slipValue->setType(ContractsTable::CUSTOM_FEE);
                $slipValue->setRecursion($recursion);
                $slipValue->setCustomId($c['id']);

                $this->values[] = $slipValue;

                break;
            }
        }

        //Status do Boleto
        $paidSlipsTable = TableRegistry::get('PaidSlips');

        $slipPaid = $paidSlipsTable->find()
            ->where(['vencimento' => $this->getSalary()->format('Y-m-d')])
            ->where(['contract_id' => $contract['id']])
            ->first();

        if ($slipPaid) {
            $this->setStatus(self::PAID);
            $this->setPaidDate(new DateTime($slipPaid['data_pago']->format('Y-m-d')));
        } else {
            $this->setPaidDate(null);

            if ($today->format('Y-m-d') > $this->getSalary()->format('Y-m-d')) {
                $this->setStatus(self::LATE);
            } else {
                $this->setStatus(self::NORMAL);
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
        }

        $recursion = new SlipValueRecursion();

        $recursion->setType(SlipsRecursiveTable::RECURSION_ALL);

        if ($isFee) {
            if (!empty($contractValues['multa'])) {
                $slipValue = new SlipValue();

                $slipValue->setName(ContractsTable::$discountOrFine[ContractsTable::FINE]);
                $slipValue->setValue(($sum * $contractValues['multa']) / 100);
                $slipValue->setType(ContractsTable::FINE);
                $slipValue->setRecursion($recursion);

                $this->values[] = $slipValue;
            }
        }

        if ($isDiscount) {
            if (!empty($contractValues['desconto'])) {
                $slipValue = new SlipValue();

                $slipValue->setName(ContractsTable::$discountOrFine[ContractsTable::DISCOUNT]);
                $slipValue->setValue((($sum * $contractValues['desconto']) / 100) * -1);
                $slipValue->setType(ContractsTable::DISCOUNT);
                $slipValue->setRecursion($recursion);

                $this->values[] = $slipValue;
            }
        }
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
}