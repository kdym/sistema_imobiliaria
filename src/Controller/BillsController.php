<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Custom\Bills;
use App\Model\Table\ParametersTable;
use App\Model\Table\PropertiesTable;
use App\Policy\BillsPolicy;
use Cake\Event\Event;
use DateTime;

/**
 * Bills Controller
 *
 * @property \App\Model\Table\PropertiesTable $Properties
 * @property \App\Model\Table\CustomBillsTable $CustomBills
 * @property \App\Model\Table\ContractsTable $Contracts
 * @property \App\Model\Table\ContractsValuesTable $ContractsValues
 * @property \App\Model\Table\PropertiesFeesTable $PropertiesFees
 * @property \App\Model\Table\CommonBillsTable $CommonBills
 * @property \App\Model\Table\ParametersTable $Parameters
 */
class BillsController extends AppController
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadModel('Properties');
        $this->loadModel('PropertiesFees');
        $this->loadModel('CustomBills');
        $this->loadModel('Contracts');
        $this->loadModel('ContractsValues');
        $this->loadModel('CommonBills');
        $this->loadModel('Parameters');
    }

    function isAuthorized($user)
    {
//        $element = $this->Users->findById($this->request->getParam('pass.0'))
//            ->first();

        return BillsPolicy::isAuthorized($this->request->action, $user);
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event); // TODO: Change the autogenerated stub

        $this->viewBuilder()->setHelpers(['Properties']);
    }

    public function saveValues()
    {
        foreach ($this->request->getData('value') as $id => $v) {
            $buffer = explode('/', $this->request->getData('period'));

            $period = new DateTime(sprintf('%s-%s-01', $buffer[1], $buffer[0]));

            $contract = $this->Contracts->find()
                ->contain('Tenants.Users')
                ->where(['property_id' => $id])
                ->where(['finalizado is null'])
                ->last();

            $hasContract = false;
            $salary = null;

            if ($contract) {
                $hasContract = true;

                $contractValues = $this->ContractsValues->find()
                    ->where(['date_format(start_date, "%Y-%m") <=' => $period->format('Y-m')])
                    ->where(['contract_id' => $contract['id']])
                    ->last();

                $salary = new DateTime(sprintf("%s-%s", $period->format('Y-m'), $contractValues['vencimento_boleto']));
            } else {
                $propertyFees = $this->PropertiesFees->find()
                    ->where(['date_format(start_date, "%Y-%m") <=' => $period->format('Y-m')])
                    ->where(['property_id' => $id])
                    ->last();

                $salary = new DateTime(sprintf("%s-%s", $period->format('Y-m'), $propertyFees[$this->request->getData('categoria')]));
            }

            $customBill = $this->CustomBills->newEntity();

            $customBill['categoria'] = $this->request->getData('categoria');
            $customBill['descricao'] = 'Conta do Imóvel';
            $customBill['pagante'] = ($hasContract) ? Bills::PAYER_RECEIVER_TENANT : Bills::PAYER_RECEIVER_LOCATOR;
            $customBill['recebedor'] = Bills::PAYER_RECEIVER_REAL_ESTATE;
            $customBill['repeat_year'] = $salary->format('Y');
            $customBill['repeat_month'] = $salary->format('m');
            $customBill['repeat_day'] = $salary->format('d');
            $customBill['data_inicio'] = $salary->format('Y-m-d');
            $customBill['data_fim'] = $salary->format('Y-m-d');
            $customBill['valor'] = $this->Properties->parseDecimal($v);
            $customBill['reference_id'] = ($hasContract) ? $contract['id'] : $id;

            $this->CustomBills->save($customBill);
        }

        $this->Flash->success('Conta lançada com sucesso');

        $this->redirect($this->referer());
    }

    public function water()
    {
        $errors = [];
        $values = [];

        if ($this->request->is('post')) {
            if (empty($this->request->getData('property_id'))) {
                $errors[] = 'Entre com o Imóvel';
            } else {
                $property = $this->Properties->get($this->request->getData('property_id'), [
                    'contain' => ['PropertiesFees']
                ]);

                if ($property['properties_fees'][0]['agua'] != true) {
                    $errors[] = 'Esse Imóvel não foi marcado para receber Contas de Água';
                }
            }

            if (empty($this->request->getData('period'))) {
                $errors[] = 'Entre com o Período';
            } else {
                $buffer = explode('/', $this->request->getData('period'));

                if (!checkdate((int)$buffer[0], 1, (int)$buffer[1])) {
                    $errors[] = 'Período inválido';
                }
            }

            if (empty($this->request->getData('value')) || $this->request->getData('value') == 'R$ 0,00') {
                $errors[] = 'Entre com o Valor';
            }

            if (empty($errors)) {
                $buffer = explode('/', $this->request->getData('period'));
                $period = new DateTime(sprintf('%s-%s-01', $buffer[1], $buffer[0]));

                $property = $this->Properties->get($this->request->getData('property_id'), [
                    'contain' => ['Locators.Users', 'PropertiesPhotos']
                ]);

                $commonBills = $this->CommonBills->find()
                    ->contain('Properties.Locators.Users')
                    ->where(['CommonBills.tipo' => PropertiesTable::BILL_WATER])
                    ->where(['property_1' => $property['id']]);

                $hasContract = [];
                $sumNoContract = 0;
                foreach ($commonBills as $c) {
                    $contract = $this->Contracts->find()
                        ->where(['property_id' => $c['property']['id']])
                        ->where(['date_format(data_inicio, "%Y-%m") >=' => $period->format('Y-m')])
                        ->where(['data_fim is not null'])
                        ->first();

                    if ($contract) {
                        $hasContract[] = $c;
                    } else {
                        $query = $this->Parameters->find()
                            ->where(['nome' => ParametersTable::MIN_WATER_RESIDENTIAL])
                            ->where(['date_format(start_date, "%Y-%m") <=' => $period->format('Y-m')])
                            ->first();

                        $minWaterValue = 0;
                        if ($query) {
                            $minWaterValue = $query['valor'];
                        }

                        $sumNoContract += $minWaterValue;

                        $values[] = [
                            'property' => $c['property'],
                            'value' => $minWaterValue
                        ];
                    }
                }

                $totalValue = $this->Properties->parseDecimal($this->request->getData('value'));

                if (!empty($hasContract)) {
                    $value = ($totalValue - $sumNoContract) / count($hasContract);
                } else {
                    $value = $totalValue - $sumNoContract;
                }

                foreach ($hasContract as $c) {
                    $values[] = [
                        'property' => $c['property'],
                        'value' => $value
                    ];
                }

                $values[] = [
                    'property' => $property,
                    'value' => $value
                ];
            }
        }

        $this->set(compact('errors', 'values'));
    }

    public function fetchPropertiesWater()
    {
        $this->autoRender = false;
        $this->response->type('json');

        $search = $this->Properties->parseSearch($this->Properties->parseCode($this->request->getQuery('name')));

        $properties = $this->Properties->find()
            ->contain('Locators.Users')
            ->contain('PropertiesFees')
            ->where([
                "OR" => [
                    "Properties.id LIKE" => $search,
                    "Properties.endereco LIKE" => $search,
                    "Properties.numero LIKE" => $search,
                    "Properties.complemento LIKE" => $search,
                    "Properties.bairro LIKE" => $search,
                    "Properties.cidade LIKE" => $search,
                    "Properties.uf LIKE" => $search,
                    "Properties.codigo_saae LIKE" => $search,
                ],
            ])
            ->limit(10);

        $this->response->body(json_encode($properties));
    }
}