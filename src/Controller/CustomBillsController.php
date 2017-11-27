<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Policy\CustomBillsPolicy;

/**
 * CustomBills Controller
 *
 * @property \App\Model\Table\CustomBillsTable $CustomBills
 */
class CustomBillsController extends AppController
{
    function isAuthorized($user)
    {
        return CustomBillsPolicy::isAuthorized($this->request->action, $user);
    }

    public function delete($id)
    {
        $customBill = $this->CustomBills->get($id);

        if ($this->CustomBills->delete($customBill)) {
            $this->Flash->success('Excluído com sucesso');

            $this->redirect($this->referer());
        }
    }
}
