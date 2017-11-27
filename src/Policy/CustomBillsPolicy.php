<?php

namespace App\Policy;

use App\Model\Custom\Bills;
use App\Model\Custom\Slip;
use App\Model\Table\ContractsValuesTable;
use App\Model\Table\UsersTable;

/**
 * Created by PhpStorm.
 * User: sknme
 * Date: 11/05/2017
 * Time: 10:10
 */
class CustomBillsPolicy
{
    public static function isAuthorized($action, $user, $element = null)
    {
        switch ($action) {
            case 'delete':
                if ($user['role'] == UsersTable::ROLE_ADMIN) {
                    if ($element) {
                        return $element->isDeletable();
                    } else {
                        return true;
                    }
                }

                return false;
        }
    }
}