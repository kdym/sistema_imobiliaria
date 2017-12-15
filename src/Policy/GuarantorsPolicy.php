<?php

namespace App\Policy;

use App\Model\Table\UsersTable;

/**
 * Created by PhpStorm.
 * User: sknme
 * Date: 11/05/2017
 * Time: 10:10
 */
class GuarantorsPolicy
{
    public static function isAuthorized($action, $user, $element = null)
    {
        switch ($action) {
            case 'form':
            case 'fetchUsers':
            case 'add':
            case 'addExisting':
            case 'delete':
                return $user['role'] == UsersTable::ROLE_ADMIN || $user['role'] == UsersTable::ROLE_BROKER;
            case 'edit':
                if ($element['role'] == UsersTable::ROLE_GUARANTOR) {
                    return $user['role'] == UsersTable::ROLE_ADMIN || $user['role'] == UsersTable::ROLE_BROKER;
                }

                return false;
        }
    }
}