<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Version helper
 */
class VersionHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    const MAJOR_VERSION = 2;
    const MINOR_VERSION = 0;
    const RELEASE_VERSION = 0;
    const BETA_VERSION = true;

    public function getVersionInfo()
    {
        $version = sprintf('%s.%s.%s', self::MAJOR_VERSION, self::MINOR_VERSION, self::RELEASE_VERSION);

        if (self::BETA_VERSION) {
            $version = sprintf('%s-beta', $version);
        }

        return $version;
    }

}
