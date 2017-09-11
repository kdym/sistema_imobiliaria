<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Locators helper
 */
class LocatorsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function hasSpouse($locator)
    {
        return !empty($locator['nome_conjuge']) ||
            !empty($locator['cpf_conjuge']) ||
            !empty($locator['data_nascimento_conjuge']);
    }

    public function hasBankInfo($locator)
    {
        return !empty($locator['banco']) ||
            !empty($locator['agencia']) ||
            !empty($locator['conta']);
    }

    public function getBank($locator)
    {
        return GlobalCombosHelper::$brazilianBanks[$locator['banco']];
    }

}
