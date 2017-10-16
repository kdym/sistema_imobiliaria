<?php
/**
 * Created by PhpStorm.
 * User: sKnMetal
 * Date: 12/10/2017
 * Time: 15:09
 */

namespace App\Model\Custom;


use App\Model\Table\SlipsRecursiveTable;
use DateTime;

class SlipValueRecursion
{
    private $type;
    private $startDate;
    private $endDate;

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

    public function toString()
    {
        switch ($this->getType()) {
            case SlipsRecursiveTable::RECURSION_ALL:
                return 'Repete Sempre';

                break;

            case SlipsRecursiveTable::RECURSION_PERIOD:
                return sprintf('Repete entre %s e %s', $this->getStartDate()->format('m/Y'), $this->getEndDate()->format('m/Y'));

                break;

            case SlipsRecursiveTable::RECURSION_START_AT:
                return sprintf('Repete a partir de %s', $this->getStartDate()->format('m/Y'));

                break;

            case SlipsRecursiveTable::RECURSION_NONE:
                return 'Não se Repete';

                break;
        }
    }
}