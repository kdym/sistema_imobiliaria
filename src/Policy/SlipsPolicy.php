<?php

namespace App\Policy;

use App\Model\Table\UsersTable;

/**
 * Created by PhpStorm.
 * User: sknme
 * Date: 11/05/2017
 * Time: 10:10
 */
class SlipsPolicy
{
    public static function isAuthorized($action, $user, $element = null)
    {
        switch ($action) {
            case 'index':
            case 'report':
                return $user['role'] == UsersTable::ROLE_ADMIN || $user['role'] == UsersTable::ROLE_BROKER;
            case 'edit':
            case 'addRecursiveFee':
            case 'deleteCustom':
                return $user['role'] == UsersTable::ROLE_ADMIN;
        }
    }
}