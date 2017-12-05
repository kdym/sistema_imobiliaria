<?php

namespace App\Policy;

use App\Model\Table\UsersTable;

/**
 * Created by PhpStorm.
 * User: sknme
 * Date: 11/05/2017
 * Time: 10:10
 */
class PropertiesPhotosPolicy
{
    public static function isAuthorized($action, $user, $element = null)
    {
        switch ($action) {
            case 'add':
            case 'fetch':
            case 'updateOrder':
            case 'delete':
                return $user['role'] == UsersTable::ROLE_ADMIN || $user['role'] == UsersTable::ROLE_BROKER;
        }
    }
}