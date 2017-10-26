<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\ContractsTable;
use App\Model\Table\ContractsValuesTable;
use App\Policy\ContractsPolicy;
use Cake\Event\Event;

/**
 * Contracts Controller
 *
 * @property \App\Model\Table\ContractsTable $Contracts
 * @property \App\Model\Table\ContractsValuesTable $ContractsValues
 * @property \App\Controller\Component\FormatterComponent $Formatter
 *
 * @method \App\Model\Entity\Contract[] paginate($object = null, array $settings = [])
 */
class ContractsController extends AppController
{

    function isAuthorized($user)
    {
//        $element = $this->Users->findById($this->request->getParam('pass.0'))
//            ->applyOptions(['withDeleted'])
//            ->first();

        return ContractsPolicy::isAuthorized($this->request->action, $user);
    }

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadComponent('Formatter');

        $this->loadModel('ContractsValues');
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event); // TODO: Change the autogenerated stub

        $this->viewBuilder()->setHelpers(['Properties', 'Contracts']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tenants.Users', 'Properties'],
            'limit' => 8
        ];
        $contracts = $this->paginate($this->Contracts);

        $this->set(compact('contracts'));
        $this->set('_serialize', ['contracts']);
    }

    /**
     * View method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contract = $this->Contracts->get($id, [
            'contain' => ['Tenants.Users', 'Properties.PropertiesPrices', 'ContractsValues']
        ]);

        $this->set('contract', $contract);
        $this->set('_serialize', ['contract']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contract = $this->Contracts->newEntity();
        if ($this->request->is('post')) {
            $contract = $this->Contracts->patchEntity($contract, $this->request->getData());
            if ($this->Contracts->save($contract)) {
                $this->Flash->success(__('The contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contract could not be saved. Please, try again.'));
        }
        $tenants = $this->Contracts->Tenants->find('list', ['limit' => 200]);
        $properties = $this->Contracts->Properties->find('list', ['limit' => 200]);
        $this->set(compact('contract', 'tenants', 'properties'));
        $this->set('_serialize', ['contract']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contract = $this->Contracts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contract = $this->Contracts->patchEntity($contract, $this->request->getData());
            if ($this->Contracts->save($contract)) {
                $this->Flash->success(__('The contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contract could not be saved. Please, try again.'));
        }
        $tenants = $this->Contracts->Tenants->find('list', ['limit' => 200]);
        $properties = $this->Contracts->Properties->find('list', ['limit' => 200]);
        $this->set(compact('contract', 'tenants', 'properties'));
        $this->set('_serialize', ['contract']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contract = $this->Contracts->get($id);
        if ($this->Contracts->delete($contract)) {
            $this->Flash->success(__('The contract has been deleted.'));
        } else {
            $this->Flash->error(__('The contract could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function form($id = null)
    {
        $this->set(compact('id'));

        if ($id) {
            $contract = $this->Contracts->get($id, [
                'contain' => ['Tenants.Users', 'Properties', 'ContractsValues']
            ]);
        } else {
            $contract = $this->Contracts->newEntity();
        }

        if ($this->request->is('get')) {
            if (!empty($contract['contracts_values'])) {
                $contract['dia_vencimento'] = $contract['contracts_values'][0]['vencimento_boleto'];
                $contract['taxa_contratual'] = $this->Formatter->formatDecimal($contract['contracts_values'][0]['taxa_contratual']);

                if (!empty($contract['contracts_values'][0]['desconto'])) {
                    $contract['discount_fine_choice'] = ContractsTable::DISCOUNT;
                    $contract['discount_fine'] = $this->Formatter->formatDecimal($contract['contracts_values'][0]['desconto']);
                } else {
                    $contract['discount_fine_choice'] = ContractsTable::FINE;
                    $contract['discount_fine'] = $this->Formatter->formatDecimal($contract['contracts_values'][0]['multa']);
                }

                foreach (ContractsValuesTable::$fees as $key => $f) {
                    $contract[$key] = $contract['contracts_values'][0][$key];
                }
            }
        }

        if ($this->request->is(['post', 'put'])) {
            if ($id) {
                $this->request->data['data_inicio'] = $contract['data_inicio']->format('d/m/Y');
            }

            $this->Contracts->patchEntity($contract, $this->request->getData());

            if ($this->Contracts->save($contract)) {
                $contractValue = $this->ContractsValues->newEntity();

                $contractValue['start_date'] = date('Y-m-d');
                $contractValue['taxa_contratual'] = $this->Contracts->parseDecimal($contract['taxa_contratual']);

                if ($contract['discount_fine_choice'] == ContractsTable::DISCOUNT) {
                    $contractValue['desconto'] = $this->Contracts->parseDecimal($contract['discount_fine']);
                    $contractValue['multa'] = null;
                } else {
                    $contractValue['multa'] = $this->Contracts->parseDecimal($contract['discount_fine']);
                    $contractValue['desconto'] = null;
                }

                foreach (ContractsValuesTable::$fees as $key => $f) {
                    $contractValue[$key] = $contract[$key];
                }

                $contractValue['contract_id'] = $contract['id'];

                if ($id) {
                    $contractValue['vencimento_boleto'] = $contract['dia_vencimento'];
                } else {
                    $contractValue['vencimento_boleto'] = substr($contract['primeiro_vencimento'], 0, 2);
                }

                if ($this->ContractsValues->save($contractValue)) {
                    $this->Flash->success('Salvo com sucesso');

                    $this->redirect(['action' => 'view', $contract['id']]);
                }
            }
        }

        $this->set(compact('contract'));
    }
}
