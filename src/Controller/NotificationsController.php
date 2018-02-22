<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Notifications Controller
 *
 */
class NotificationsController extends AppController
{
    public function bills()
    {
        $this->autoRender = false;
        $this->response->type('json');

        $response = [];

        $sum = 0;

        $billsController = new BillsController();

        $absentBills = $billsController->findAbsentBills();

        $sum += count($absentBills);

        $response = [
            'absent' => count($absentBills),
            'total' => $sum,
        ];

        $this->response->body(json_encode($response));
    }
}
