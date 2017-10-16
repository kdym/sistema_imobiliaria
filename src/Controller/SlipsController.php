<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Custom\Slip;
use App\Model\Table\ContractsTable;
use App\Model\Table\ContractsValuesTable;
use App\Model\Table\SlipsCustomsValuesTable;
use App\Model\Table\SlipsRecursiveTable;
use App\Policy\SlipsPolicy;
use Cake\Event\Event;
use DateInterval;
use DatePeriod;
use DateTime;

/**
 * Slips Controller
 *
 * @property \App\Model\Table\ContractsTable $Contracts
 * @property \App\Model\Table\PropertiesPricesTable $PropertiesPrices
 * @property \App\Model\Table\ContractsValuesTable $ContractsValues
 * @property \App\Model\Table\CompanyDataTable $CompanyData
 * @property \App\Model\Table\SlipsRecursiveTable $SlipsRecursive
 * @property \App\Model\Table\SlipsCustomsValuesTable $SlipsCustomsValues
 *
 */
class SlipsController extends AppController
{

    function isAuthorized($user)
    {
//        $element = $this->Users->findById($this->request->getParam('pass.0'))
//            ->first();

        return SlipsPolicy::isAuthorized($this->request->action, $user);
    }

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadModel('Contracts');
        $this->loadModel('PropertiesPrices');
        $this->loadModel('CompanyData');
        $this->loadModel('ContractsValues');
        $this->loadModel('SlipsRecursive');
        $this->loadModel('SlipsCustomsValues');
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event); // TODO: Change the autogenerated stub

        $this->viewBuilder()->setHelpers(['Slips', 'CompanyData']);
    }

    public function index($contractId)
    {
        $contract = $this->Contracts->get($contractId, [
            'contain' => ['Properties.PropertiesPrices', 'ContractsValues']
        ]);
        $companyData = $this->CompanyData->find()->first();

        $this->set(compact('contract', 'companyData'));

        $startDate = new DateTime('now');
        $endDate = new DateTime('now');

        if ($this->request->is('post')) {
            $period = explode(' a ', $this->request->getData('period'));

            $startDate = new DateTime($this->Contracts->parseDate($period[0]));
            $endDate = new DateTime($this->Contracts->parseDate($period[1]));
        }

        $startDate->modify('first day of this month');
        $endDate->modify('last day of this month');

        $this->set(compact('startDate', 'endDate'));

        $slips = $this->findSlipsInPeriod($contract, $startDate, $endDate);

        $this->set(compact('slips'));
    }

    public function getSlipInfo($date, $contract, $contractValues)
    {
        $values = [];

        $sum = 0;

        $today = new DateTime('now');
        $firstSalary = new DateTime($contract['primeiro_vencimento']->format('Y-m-d'));
        $ownDate = new DateTime($contract['data_posse']->format('Y-m-d'));

        //Aluguel
        $recursiveRent = $this->SlipsRecursive->find()
            ->where(['contract_id' => $contract['id']])
            ->where(['tipo' => ContractsTable::RENT]);

        $propertyPrice = $this->PropertiesPrices->find()
            ->where(['date_format(start_date, "%Y-%m") <=' => $date->format('Y-m')])
            ->where(['property_id' => $contract['property_id']])
            ->last();

        if (!$propertyPrice) {
            $propertyPrice = $this->PropertiesPrices->find()
                ->where(['property_id' => $contract['property_id']])
                ->last();
        }

        $rent = $propertyPrice['valor'];

        if ($date->format('Y-m') == $firstSalary->format('Y-m')) {
            $diff = $ownDate->diff($firstSalary);

            $rent = ($propertyPrice['valor'] * ($diff->days + 1)) / ContractsTable::DEFAULT_MONTH_DAYS;
        }

        $recursion = SlipsRecursiveTable::RECURSION_ALL;

        $values[] = [
            'name' => ContractsTable::$feesNames[ContractsTable::RENT],
            'value' => $rent,
            'type' => ContractsTable::RENT,
            'recursion' => $recursion
        ];

        $sum += $rent;

        //Taxas Extras
        foreach (ContractsValuesTable::$fees as $key => $f) {
            if (!empty($contractValues[$key]) && $key <> ContractsValuesTable::CPMF) {
                $value = $this->getExtraFees($date, $key);

                $recursion = SlipsRecursiveTable::RECURSION_ALL;

                $values[] = [
                    'name' => $f,
                    'value' => $value,
                    'type' => $key,
                    'recursion' => $recursion
                ];

                $sum += $value;
            }
        }

        //Desconto/Multa
        if ($today > $date) {
            if (!empty($contractValues['multa'])) {
                $values[] = [
                    'name' => ContractsTable::$discountOrFine[ContractsTable::FINE],
                    'value' => ($sum * $contractValues['multa']) / 100,
                    'type' => ContractsTable::FINE,
                ];
            }
        } else {
            if (!empty($contractValues['desconto'])) {
                $values[] = [
                    'name' => ContractsTable::$discountOrFine[ContractsTable::DISCOUNT],
                    'value' => (($sum * $contractValues['desconto']) / 100) * -1,
                    'type' => ContractsTable::DISCOUNT,
                ];
            }
        }

        return $values;
    }

    public function getExtraFees($date, $fee)
    {
        return 0;
    }

    public function report($contractId)
    {
        $this->viewBuilder()->setLayout('slip');

        $contract = $this->Contracts->get($contractId, [
            'contain' => [
                'Properties.Locators.Users',
                'Tenants.Users'
            ]
        ]);

        $companyData = $this->CompanyData->find()->first();

        $this->set(compact('contract', 'companyData'));

        $startDate = new DateTime($this->request->getQuery('start_date'));
        $endDate = new DateTime($this->request->getQuery('end_date'));

        $slips = $this->findSlipsInPeriod($contract, $startDate, $endDate);

        $this->set(compact('slips'));
    }

    public function findSlipsInPeriod($contract, DateTime $startDate, DateTime $endDate)
    {
        $interval = new DatePeriod($startDate, new DateInterval('P1M'), $endDate);

        $slips = [];
        foreach ($interval as $d) {
            if ($d->format('Y-m') >= $contract['primeiro_vencimento']->format('Y-m')) {
                $slips[] = new Slip($contract, $d);
            }
        }

        return $slips;
    }

    public function edit($contractId)
    {
        $slipDate = new DateTime($this->Contracts->parseDate($this->request->getQuery('slip')));
        $contract = $this->Contracts->get($contractId, [
            'contain' => ['Properties.PropertiesPrices', 'ContractsValues']
        ]);

        $this->set(compact('slipDate', 'contract'));

        $startDate = new DateTime($slipDate->format('Y-m-d'));
        $endDate = new DateTime($slipDate->format('Y-m-d'));

        $startDate->modify('first day of this month');
        $endDate->modify('last day of this month');

        $slips = $this->findSlipsInPeriod($contract, $startDate, $endDate);

        $oldValues = [];
        foreach ($slips[0]->getValues() as $v) {
            if ($v->getType() <> ContractsTable::CUSTOM_FEE) {
                $oldValues[$v->getType()] = $v->getValue();
            } else {
                $oldValues[$v->getCustomId()] = $v->getValue();
            }
        }

        $this->set('slipValues', $slips[0]);

        if ($this->request->is('post')) {
            foreach ($this->request->getData('name') as $key => $name) {
                $type = $this->request->getData('type')[$key];
                $value = $this->Contracts->parseDecimal($this->request->getData('value')[$key]);
                $customId = $this->request->getData('custom_id')[$key];

                if ($type == ContractsTable::CUSTOM_FEE) {
                    if ($oldValues[$customId] == $value) {
                        continue;
                    }
                } else {
                    if ($oldValues[$type] == $value) {
                        continue;
                    }
                }

                $customValue = $this->SlipsRecursive->newEntity();

                $customValue['start_date'] = $slipDate->format('Y-m-d');
                $customValue['end_date'] = $slipDate->format('Y-m-d');
                $customValue['deleted'] = false;
                $customValue['tipo'] = $type;
                $customValue['valor'] = $value;
                $customValue['contract_id'] = $contractId;
                $customValue['slip_custom_id'] = $customId;

                $this->SlipsRecursive->save($customValue);
            }

            $this->Flash->success('Salvo com sucesso');

            $this->redirect(['controller' => 'slips', 'action' => 'index', $contractId]);
        }
    }

    public function addRecursiveFee($contractId)
    {
        $customValue = $this->SlipsCustomsValues->newEntity();

        $customValue['descricao'] = $this->request->getData('name');
        $customValue['valor'] = $this->Contracts->parseDecimal($this->request->getData('value'));
        $customValue['contract_id'] = $contractId;

        if ($this->SlipsCustomsValues->save($customValue)) {
            $recursion = $this->SlipsRecursive->newEntity();

            switch ($this->request->getData('recursive')) {
                case SlipsRecursiveTable::RECURSION_NONE:
                    $recursion['start_date'] = $this->request->getData('slip_date');
                    $recursion['end_date'] = $this->request->getData('slip_date');

                    break;

                case SlipsRecursiveTable::RECURSION_ALL:
                    $recursion['start_date'] = null;
                    $recursion['end_date'] = null;

                    break;

                case SlipsRecursiveTable::RECURSION_START_AT:
                    $recursion['start_date'] = $this->Contracts->parseDate($this->request->getData('start_at_input'));
                    $recursion['end_date'] = null;

                    break;

                case SlipsRecursiveTable::RECURSION_PERIOD:
                    $period = explode(' a ', $this->request->getData('period_input'));

                    $recursion['start_date'] = $this->Contracts->parseDate($period[0]);
                    $recursion['end_date'] = $this->Contracts->parseDate($period[1]);

                    break;
            }

            $recursion['deleted'] = false;
            $recursion['slip_custom_id'] = $customValue['id'];
            $recursion['tipo'] = ContractsTable::CUSTOM_FEE;
            $recursion['contract_id'] = $contractId;
            $recursion['valor'] = $this->Contracts->parseDecimal($this->request->getData('value'));

            if ($this->SlipsRecursive->save($recursion)) {
                $this->Flash->success('Salvo com sucesso');

                $this->redirect(['controller' => 'slips', 'action' => 'index', $contractId]);
            }
        }
    }

    public function deleteCustom()
    {
        $recursive = $this->SlipsRecursive->newEntity();

        $slipDate = new DateTime($this->request->getData('slip_date'));

        $recursive['start_date'] = $slipDate->format('Y-m-d');
        $recursive['deleted'] = true;
        $recursive['slip_custom_id'] = $this->request->getData('custom_id');
        $recursive['tipo'] = ContractsTable::CUSTOM_FEE;
        $recursive['contract_id'] = $this->request->getData('contract_id');

        switch ($this->request->getData('delete_option')) {
            case SlipsRecursiveTable::DELETE_SINGLE:
                $recursive['end_date'] = $slipDate->format('Y-m-d');

                $this->SlipsRecursive->save($recursive);

                break;

            case SlipsRecursiveTable::DELETE_NEXT:
                $recursive['end_date'] = null;

                $this->SlipsRecursive->save($recursive);

                break;

            case SlipsRecursiveTable::DELETE_ALL:
                $slipCustomValue = $this->SlipsCustomsValues->get($this->request->getData('custom_id'));

                $this->SlipsCustomsValues->delete($slipCustomValue);

                break;
        }

        $this->Flash->success('Excluído com sucesso');

        $this->redirect(['action' => 'index', $this->request->getData('contract_id')]);
    }
}