<?php

namespace App\Policy;

use App\Model\Custom\Slip;
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
            case 'paySlip':
            case 'payMultiple':
                return $user['role'] == UsersTable::ROLE_ADMIN || $user['role'] == UsersTable::ROLE_BROKER;
            case 'addRecursiveFee':
            case 'deleteCustom':
            case 'unPaySlip':
                return $user['role'] == UsersTable::ROLE_ADMIN;
            case 'edit':
                if ($element) {
                    if ($user['role'] == UsersTable::ROLE_ADMIN) {
                        return $element->getStatus() <> Slip::PAID;
                    }
                } else {
                    return $user['role'] == UsersTable::ROLE_ADMIN;
                }

                return false;
            case 'pay':
                if ($user['role'] == UsersTable::ROLE_ADMIN || $user['role'] == UsersTable::ROLE_BROKER) {
                    return $element->getStatus() <> Slip::PAID;
                }

                return false;

            case 'unPay':
                if ($user['role'] == UsersTable::ROLE_ADMIN) {
                    return $element->getStatus() == Slip::PAID;
                }

                return false;
        }
    }
}