<?php

namespace App\View\Helper;

use App\Model\Table\UsersTable;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Users helper
 */
class UsersHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getUsername($user)
    {
        if (is_numeric($user['username'])) {
            return str_pad($user['username'], UsersTable::MAX_USER_CHARS, '0', STR_PAD_LEFT);
        } else {
            return $user['username'];
        }
    }

    public function getRole($user)
    {
        return UsersTable::$roles[$user['role']];
    }

    public function getCivilState($user)
    {
        return GlobalCombosHelper::$civilStates[$user['estado_civil']];
    }

    public function getClassFlag($user)
    {
        if ($user['deleted'] == true) {
            return 'text-muted';
        }
    }

    public function hasAddress($user)
    {
        return !empty($user['endereco'])
            && !empty($user['numero'])
            && !empty($user['bairro'])
            && !empty($user['cidade'])
            && !empty($user['uf'])
            && !empty($user['cep']);
    }

}
