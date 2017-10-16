<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * SlipsCustomsValues helper
 */
class SlipsCustomsValuesHelper extends Helper
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
