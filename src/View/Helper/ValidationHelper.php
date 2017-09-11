<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Validation helper
 */
class ValidationHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    const PHONE_DDD_EXPRESSION = '/\(\d{2}\) \d?\d{4}\-\d{4}/';
    const CEP_EXPRESSION = '/\d{5}\-\d{3}/';
    const CPF_EXPRESSION = '/\d{3}\.\d{3}\.\d{3}\-\d{2}/';
    const CNPJ_EXPRESSION = '/\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}/';

}
