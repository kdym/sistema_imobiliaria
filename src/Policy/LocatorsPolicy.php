<?php

namespace App\Policy;

use App\Model\Table\UsersTable;

/**
 * Created by PhpStorm.
 * User: sknme
 * Date: 11/05/2017
 * Time: 10:10
 */
class LocatorsPolicy
{
    public static function isAuthorized($action, $user, $element = null)
    {
        switch ($action) {
            case 'index':
            case 'delete':
                return $user['role'] == UsersTable::ROLE_ADMIN;
            case 'form':
                return $user['role'] == UsersTable::ROLE_ADMIN && $element['role'] == UsersTable::ROLE_LOCATOR;
        }
    }
}