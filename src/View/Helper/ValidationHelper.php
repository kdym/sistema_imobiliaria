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

}
