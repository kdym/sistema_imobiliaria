<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\ContractsValuesTable;
use App\Policy\ConfigPolicy;

/**
 * Config Controller
 *
 * @property \App\Model\Table\CompanyDataTable $CompanyData
 * @property \App\Model\Table\ParametersTable $Parameters
 *
 * @method \App\Model\Entity\Config[] paginate($object = null, array $settings = [])
 */
class ConfigController extends AppController
{
    function isAuthorized($user)
    {
//        $element = $this->Users->findById($this->request->getParam('pass.0'))
//            ->applyOptions(['withDeleted'])
//            ->first();

        return ConfigPolicy::isAuthorized($this->request->action, $user);
    }

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadModel('CompanyData');
        $this->loadModel('Parameters');
        $this->loadModel('ContractsValues');
    }

    public function index()
    {
        $companyData = $this->CompanyData->find()->first();

        $this->set(compact('companyData'));
    }

    public function general()
    {
        if ($this->request->is('post')) {
            foreach (ContractsValuesTable::$generalFees as $f) {
                $parameter = $this->Parameters->newEntity();

                $parameter['nome'] = $f->getKey();
                $parameter['valor'] = $this->Parameters->parseDecimal($this->request->getData($f->getKey()));
                $parameter['start_date'] = date('Y-m-d');

                $this->Parameters->save($parameter);
            }

            $this->Flash->success('Salvo com sucesso');

            $this->redirect(['action' => 'index']);
        }
    }
}