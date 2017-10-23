<?php
/**
 * Created by PhpStorm.
 * User: sKnMetal
 * Date: 23/10/2017
 * Time: 15:56
 */

namespace App\Model\Custom;


use Cake\ORM\TableRegistry;
use DateTime;

class GeneralFee
{
    const CURRENCY = 'currency';
    const PERCENT = 'percent';

    private $key;
    private $name;
    private $type;
    private $icon;

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
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
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getValue(DateTime $date = null)
    {
        $parametersTable = TableRegistry::get('Parameters');

        if (!$date) {
            $date = new DateTime('now');
        }

        $parameter = $parametersTable->find()
            ->where(['nome' => $this->getKey()])
            ->where(['start_date >=' => $date->format('Y-m-d')])
            ->last();

        if (!$parameter) {
            $parameter = $parametersTable->find()
                ->where(['nome' => $this->getKey()])
                ->last();
        }

        return ($parameter) ? $parameter['valor'] : 0;
    }

    public function getFormattedValue(DateTime $date = null)
    {
        $value = $this->getValue($date);

        if ($this->getType() == self::CURRENCY) {
            return 'R$ ' . number_format($value, 2, ',', '.');
        } else {
            return number_format($value, 2, ',', '.') . '%';
        }
    }

    public function getTypeSymbol()
    {
        switch ($this->getType()) {
            case self::CURRENCY:
                return 'R$';
            case self::PERCENT:
                return '%';
        }
    }
}