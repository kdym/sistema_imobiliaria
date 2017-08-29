<?php

namespace App\Policy;

use App\Model\Table\UsersTable;

/**
 * Created by PhpStorm.
 * User: sknme
 * Date: 11/05/2017
 * Time: 10:10
 */
class UsersPolicy
{
    public static function isAuthorized($action, $user, $element = null)
    {
        switch ($action) {
            case 'index':
            case 'form':
                return $user['role'] == UsersTable::ROLE_ADMIN && $element['deleted'] == false;
            case "logout":
            case "notAuthorized":
            case "profile":
            case "show":
                return true;
            case 'delete':
                return $user['role'] == UsersTable::ROLE_ADMIN && $user['id'] != $element['id'] && $element['deleted'] == false;
            case 'undelete':
                return $user['role'] == UsersTable::ROLE_ADMIN && $element['deleted'] == true;
            case 'show_edit_profile':
                return $user['id'] == $element['id'];
            case 'delete_avatar':
                return $user['role'] == UsersTable::ROLE_ADMIN || $user['id'] == $element['id'];
        }
    }
}