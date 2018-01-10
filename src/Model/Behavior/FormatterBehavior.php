<?php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Formatter behavior
 */
class FormatterBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function formatCurrency($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}
