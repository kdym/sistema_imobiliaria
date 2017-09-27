<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Slips helper
 */
class SlipsHelper extends Helper
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

    public function getSlipClass()
    {
        return 'bg-primary';
    }
}
