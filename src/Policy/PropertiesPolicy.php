<?php

namespace App\Policy;

use App\Model\Table\UsersTable;

/**
 * Created by PhpStorm.
 * User: sknme
 * Date: 11/05/2017
 * Time: 10:10
 */
class PropertiesPolicy
{
    public static function isAuthorized($action, $user, $element = null)
    {
        switch ($action) {
            case 'index':
            case 'form':
            case 'view':
            case 'fetch':
            case 'fetchBroker':
            case 'updateLatitudeLongitude':
                return $user['role'] == UsersTable::ROLE_ADMIN || $user['role'] == UsersTable::ROLE_BROKER;
            case 'delete':
            case 'billEntries':
                return $user['role'] == UsersTable::ROLE_ADMIN;
        }
    }
}