<?php
/**
 * Created by PhpStorm.
 * User: sKnMetal
 * Date: 22/11/2017
 * Time: 17:03
 */

namespace App\Model\Custom;


use DateTime;

class Recursivity
{
    private $type;
    private $startDate;
    private $endDate;

    const RECURSIVITY_ALWAYS = 'always';
    const RECURSION_NONE = 'none';
    const RECURSION_START_AT = 'start_at';
    const RECURSION_PERIOD = 'period';

    public static $recursions = [
        self::RECURSIVITY_ALWAYS => "Repete Sempre",
        self::RECURSION_NONE => "Data Específica",
        self::RECURSION_START_AT => "Começa em",
        self::RECURSION_PERIOD => "Período",
    ];

    public function __construct($customBill = null)
    {
        if (!empty($customBill)) {
            if (
                $customBill['repeat_year'] == '*' &&
                $customBill['repeat_month'] == '*' &&
                empty($customBill['data_inicio']) &&
                empty($customBill['data_fim'])
            ) {
                $this->setType(self::RECURSIVITY_ALWAYS);
            }

            if (
                $customBill['repeat_year'] == '*' &&
                $customBill['repeat_month'] == '*' &&
                !empty($customBill['data_inicio']) &&
                empty($customBill['data_fim'])
            ) {
                $this->setType(self::RECURSION_START_AT);
                $this->setStartDate(new DateTime($customBill['data_inicio']->format('Y-m-d')));
            }

            if (
                $customBill['repeat_year'] == '*' &&
                $customBill['repeat_month'] == '*' &&
                !empty($customBill['data_inicio']) &&
                !empty($customBill['data_fim'])
            ) {
                $this->setType(self::RECURSION_PERIOD);
                $this->setStartDate(new DateTime($customBill['data_inicio']->format('Y-m-d')));
                $this->setEndDate(new DateTime($customBill['data_fim']->format('Y-m-d')));
            }

            if (
                $customBill['repeat_year'] != '*' &&
                $customBill['repeat_month'] != '*' &&
                $customBill['repeat_day'] != '*'
            ) {
                $this->setType(self::RECURSION_NONE);
                $this->setStartDate(new DateTime($customBill['data_inicio']->format('Y-m-d')));
            }
        }
    }

    public function toString()
    {
        switch ($this->getType()) {
            case self::RECURSIVITY_ALWAYS:
                return 'Repete Sempre';

                break;

            case self::RECURSION_START_AT:
                return sprintf('Repete a partir de %s', $this->getStartDate()->format('d/m/Y'));

                break;

            case self::RECURSION_PERIOD:
                $diff = $this->getEndDate()->diff($this->getStartDate());
                $plots = __('{0, plural, =0{} =1{(1 parcela)} other{(# parcelas)}}', $diff->m);

                return sprintf('Repete entre %s e %s %s', $this->getStartDate()->format('d/m/Y'), $this->getEndDate()->format('d/m/Y'), $plots);

                break;

            case self::RECURSION_NONE:
                return sprintf('Não se repete (%s)', $this->getStartDate()->format('d/m/Y'));
        }
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
}