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
        $value = str_replace(['R$ ', '.'], '', $value);
        $value = str_replace(',', '.', $value);

        return $value;
    }
}
