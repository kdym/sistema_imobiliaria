<?php

namespace App\Policy;

use App\Model\Table\UsersTable;

/**
 * Created by PhpStorm.
 * User: sknme
 * Date: 11/05/2017
 * Time: 10:10
 */
class BillsPolicy
{
    public static function isAuthorized($action, $user, $element = null)
    {
        switch ($action) {
            case 'index':
            case 'saveValues':
            case 'water':
            case 'fetchPropertiesWater':
            case 'propertyHasWater':
                return $user['role'] == UsersTable::ROLE_ADMIN;
        }
    }
}