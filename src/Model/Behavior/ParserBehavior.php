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
        return str_replace(',', '.', str_replace(['R$ ', '.'], '', $value));
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
