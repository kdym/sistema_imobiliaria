<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Policy\DashboardPolicy;

/**
 * Dashboard Controller
 *
 */
class DashboardController extends AppController
{

    function isAuthorized($user)
    {
//        $element = $this->Users->findById($this->request->getParam('pass.0'))
//            ->applyOptions(['withDeleted'])
//            ->first();

        return DashboardPolicy::isAuthorized($this->request->action, $user);
    }

    public function index()
    {

    }
}
