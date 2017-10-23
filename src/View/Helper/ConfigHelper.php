<?php

namespace App\View\Helper;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Config helper
 */
class ConfigHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getGeneralFee($name)
    {
        $parametersTable = TableRegistry::get('Parameters');

        $parameter = $parametersTable->find()
            ->where(['nome' => $name])
            ->last();

        return ($parameter) ? $parameter['valor'] : 0;
    }

}
