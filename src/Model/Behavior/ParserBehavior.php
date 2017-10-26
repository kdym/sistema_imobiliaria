<?php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Parser behavior
 */
class ParserBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function parseDecimal($value)
    {
        if ($value) {
            $value = str_replace(['R$ ', '.', '%'], '', $value);
            $value = str_replace(',', '.', $value);

            return $value;
        } else {
            return 0;
        }
    }

    public function parseDate($value)
    {
        return implode('-', array_reverse(explode('/', $value)));
    }

    public function parseSearch($value)
    {
        return '%' . str_replace(' ', '%', $value) . '%';
    }
}
