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
 * @property \App\Model\Table\BillsTransactionsTable $BillsTransactions
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
        $this->loadModel('BillsTransactions');
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
        $today = new DateTime('now');

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
            $value = $this->Properties->parseDecimal($v);
            $description = 'Conta do Imóvel';
            $category = $this->request->getData('categoria');

            if ($contract) {
                $hasContract = true;

                $isLocked = false;
                $isPaid = false;

                $contractValues = $this->ContractsValues->find()
                    ->where(['date_format(start_date, "%Y-%m") <=' => $period->format('Y-m')])
                    ->where(['contract_id' => $contract['id']])
                    ->last();

                $salary = new DateTime(sprintf("%s-%s", $period->format('Y-m'), $contractValues['vencimento_boleto']));

                $paidSlips = $this->BillsTransactions->find()
                    ->where(['categoria' => $this->request->getData('categoria')])
                    ->where(['reference_id' => $contract['id']])
                    ->where(['date_format(data_vencimento, "%Y-%m") = :date'])
                    ->bind(':date', $period->format('Y-m'))
                    ->where(['data_pago is not null'])
                    ->first();

                if ($paidSlips) {
                    $isPaid = true;

                    $value -= $paidSlips['valor'];
                    $description = 'Diferença Mês Anterior';
                } else {
                    $slipLock = $this->Parameters->find()
                        ->where(['nome' => ParametersTable::SLIP_LOCK])
                        ->where(['date_format(start_date, "%Y-%m") <= :date'])
                        ->bind(':date', $period->format('Y-m'))
                        ->last();

                    if ($slipLock) {
                        $lockDay = new DateTime(sprintf('%s-%s', $period->format('Y-m'), $slipLock['valor']));

                        if ($today->format('Y-m-d') >= $lockDay->format('Y-m-d')) {
                            $isLocked = true;

                            $lastMonth = new DateTime($salary->format('Y-m-d'));
                            $lastMonth->modify('-1 month');

                            $isPosted = $this->CustomBills->find()
                                ->where(['reference_id' => $contract['id']])
                                ->where(['pagante' => Bills::PAYER_RECEIVER_TENANT])
                                ->where(['categoria' => $this->request->getData('categoria')])
                                ->where(['date_format(data_inicio, "%Y-%m") = :date'])
                                ->bind(':date', $lastMonth->format('Y-m'))
                                ->first();

                            if ($isPosted) {
                                $value -= $isPosted['valor'];
                                $description = 'Diferença Mês Anterior';
                            } else {
                                $minValue = 0;
                                $parameter = null;

                                $propertyFees = $this->PropertiesFees->find()
                                    ->where(['property_id' => $id])
                                    ->where(['date_format(start_date, "%Y-%m") <= :date'])
                                    ->bind(':date', $period->format('Y-m'))
                                    ->last();

                                switch ($this->request->getData('categoria')) {
                                    case PropertiesTable::BILL_WATER:
                                        switch ($propertyFees['imovel_tipo']) {
                                            case PropertiesTable::TYPE_RESIDENTIAL:
                                                $parameter = ParametersTable::MIN_WATER_RESIDENTIAL;

                                                break;

                                            case PropertiesTable::TYPE_NON_RESIDENTIAL:
                                                $parameter = ParametersTable::MIN_WATER_NON_RESIDENTIAL;

                                                break;
                                        }

                                        break;
                                }

                                $query = $this->Parameters->find()
                                    ->where(['nome' => $parameter])
                                    ->where(['date_format(start_date, "%Y-%m") <= :date'])
                                    ->bind(':date', $period->format('Y-m'))
                                    ->last();

                                if ($query) {
                                    $minValue = $query['valor'];
                                }

                                $value -= $minValue;
                                $description = 'Diferença Mês Anterior';
                            }
                        }
                    }
                }

                if ($isPaid || $isLocked) {
                    if ($isLocked) {
                        $newLockDay = new DateTime(sprintf('%s-%s', $period->format('Y-m'), $slipLock['valor']));

                        while ($today->format('Y-m-d') >= $newLockDay->format('Y-m-d')) {
                            $newLockDay->modify('+1 month');

                            $salary = $newLockDay;
                        }
                    } else {
                        $salary->modify('+1 month');
                    }

                    switch ($this->request->getData('categoria')) {
                        case PropertiesTable::BILL_WATER:
                            $category = PropertiesTable::DIFFERENCE_WATER;

                            break;
                    }
                }
            } else {
                $propertyFees = $this->PropertiesFees->find()
                    ->where(['date_format(start_date, "%Y-%m") <=' => $period->format('Y-m')])
                    ->where(['property_id' => $id])
                    ->last();

                $salary = new DateTime(sprintf("%s-%s", $period->format('Y-m'), $propertyFees[$this->request->getData('categoria')]));
            }

            $reference = ($hasContract) ? $contract['id'] : $id;

            $buffer = $this->CustomBills->find()
                ->where(['categoria' => $category])
                ->where(['repeat_year' => $salary->format('Y')])
                ->where(['repeat_month' => $salary->format('m')])
                ->where(['reference_id' => $reference])
                ->first();

            if ($buffer) {
                $customBill = $buffer;
            } else {
                $customBill = $this->CustomBills->newEntity();
            }

            $customBill['categoria'] = $category;
            $customBill['descricao'] = $description;
            $customBill['pagante'] = ($hasContract) ? Bills::PAYER_RECEIVER_TENANT : Bills::PAYER_RECEIVER_LOCATOR;
            $customBill['recebedor'] = Bills::PAYER_RECEIVER_REAL_ESTATE;
            $customBill['repeat_year'] = $salary->format('Y');
            $customBill['repeat_month'] = $salary->format('m');
            $customBill['repeat_day'] = $salary->format('d');
            $customBill['data_inicio'] = $salary->format('Y-m-d');
            $customBill['data_fim'] = $salary->format('Y-m-d');
            $customBill['valor'] = $value;
            $customBill['reference_id'] = $reference;

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
                    if ($contract = $this->hasActiveContract($c['property'], $period)) {
                        $hasContract[] = $contract;
                    } else {
                        $propertyFees = $this->PropertiesFees->find()
                            ->where(['property_id' => $c['property']['id']])
                            ->where(['date_format(start_date, "%Y-%m") <= :date'])
                            ->bind(':date', $period->format('Y-m'))
                            ->last();

                        switch ($propertyFees['imovel_tipo']) {
                            case PropertiesTable::TYPE_RESIDENTIAL:
                                $parameter = ParametersTable::MIN_WATER_RESIDENTIAL;

                                break;

                            case PropertiesTable::TYPE_NON_RESIDENTIAL:
                                $parameter = ParametersTable::MIN_WATER_NON_RESIDENTIAL;

                                break;
                        }

                        $query = $this->Parameters->find()
                            ->where(['nome' => $parameter])
                            ->where(['date_format(start_date, "%Y-%m") <= :date'])
                            ->bind(':date', $period->format('Y-m'))
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
                    $warning = '';

                    $isValidSlip = $this->isValidSlip($period, $c);

                    if ($isValidSlip['paid'] == true || $isValidSlip['locked'] == true) {
                        $warning = 'Boleto Fechado';
                    }

                    $values[] = [
                        'property' => $c['property'],
                        'value' => $value,
                        'warning' => $warning
                    ];
                }

                if ($contract = $this->hasActiveContract($property, $period)) {
                    $warning = '';

                    $isValidSlip = $this->isValidSlip($period, $contract);

                    if ($isValidSlip['paid'] == true || $isValidSlip['locked'] == true) {
                        $warning = 'Boleto Fechado';
                    }
                }

                $values[] = [
                    'property' => $property,
                    'value' => $value,
                    'warning' => $warning
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

    public function isValidSlip($period, $contract)
    {
        $result = [
            'paid' => false,
            'locked' => false,
        ];

        $paidSlips = $this->BillsTransactions->find()
            ->where(['reference_id' => $contract['id']])
            ->where(['date_format(data_vencimento, "%Y-%m") = :date'])
            ->bind(':date', $period->format('Y-m'))
            ->where(['data_pago is not null']);

        if (!$paidSlips->isEmpty()) {
            $result['paid'] = true;
        }

        $today = new DateTime('now');

        $slipLock = $this->Parameters->find()
            ->where(['nome' => ParametersTable::SLIP_LOCK])
            ->where(['date_format(start_date, "%Y-%m") <= :date'])
            ->bind(':date', $period->format('Y-m'))
            ->last();

        if ($slipLock) {
            $lockDay = new DateTime(sprintf('%s-%s', $period->format('Y-m'), $slipLock['valor']));

            if ($today->format('Y-m-d') >= $lockDay->format('Y-m-d')) {
                $result['locked'] = true;
            }
        }

        return $result;
    }

    public function hasActiveContract($property, $period)
    {
        $contract = $this->Contracts->find()
            ->where(['property_id' => $property['id']])
            ->where(['date_format(data_inicio, "%Y-%m") <= :date'])
            ->bind(':date', $period->format('Y-m'))
            ->where(['data_fim is null'])
            ->first();

        return $contract;
    }
}
