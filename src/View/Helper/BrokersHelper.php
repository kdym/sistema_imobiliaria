<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Brokers helper
 */
class BrokersHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getComission($broker)
    {
        if ($broker['tipo_comissao'] == GlobalCombosHelper::COMISSION_TYPE_PERCENTAGE) {
            return number_format($broker['comissao'], 2, ',', '.') . '%';
        } else {
            return 'R$ ' . number_format($broker['comissao'], 2, ',', '.');
        }
    }

}
