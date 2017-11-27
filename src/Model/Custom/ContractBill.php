<?php
/**
 * Created by PhpStorm.
 * User: sKnMetal
 * Date: 22/11/2017
 * Time: 16:58
 */

namespace App\Model\Custom;


class ContractBill
{
    private $salary;
    private $name;
    private $recursivity;
    private $value;
    private $deletable;
    private $customBillId;

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRecursivity()
    {
        return $this->recursivity;
    }

    /**
     * @param mixed $recursivity
     */
    public function setRecursivity($recursivity)
    {
        $this->recursivity = $recursivity;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function isDeletable()
    {
        return $this->deletable;
    }

    /**
     * @param mixed $deletable
     */
    public function setDeletable($deletable)
    {
        $this->deletable = $deletable;
    }

    /**
     * @return mixed
     */
    public function getCustomBillId()
    {
        return $this->customBillId;
    }

    /**
     * @param mixed $customBillId
     */
    public function setCustomBillId($customBillId)
    {
        $this->customBillId = $customBillId;
    }
}