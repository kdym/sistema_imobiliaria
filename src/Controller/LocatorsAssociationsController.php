<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\PropertiesTable;
use App\Policy\LocatorsAssociationsPolicy;

/**
 * LocatorsAssociations Controller
 *
 * @property \App\Model\Table\LocatorsAssociationsTable $LocatorsAssociations
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\PropertiesTable $Properties
 *
 * @method \App\Model\Entity\LocatorsAssociation[] paginate($object = null, array $settings = [])
 */
class LocatorsAssociationsController extends AppController
{

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadModel('Users');
        $this->loadModel('Properties');
    }

    function isAuthorized($user)
    {
        return LocatorsAssociationsPolicy::isAuthorized($this->request->action, $user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $locatorsAssociations = $this->paginate($this->LocatorsAssociations);

        $this->set(compact('locatorsAssociations'));
        $this->set('_serialize', ['locatorsAssociations']);
    }

    /**
     * View method
     *
     * @param string|null $id Locators Association id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locatorsAssociation = $this->LocatorsAssociations->get($id, [
            'contain' => []
        ]);

        $this->set('locatorsAssociation', $locatorsAssociation);
        $this->set('_serialize', ['locatorsAssociation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function form($propertyId)
    {
        $property = $this->Properties->get($propertyId, [
            'contain' => [
                'Locators.Users',
                'PropertiesFees'
            ]
        ]);

        $referer = $this->referer();

        $this->set(compact('property', 'referer'));

        $associations = $this->LocatorsAssociations->find()
            ->contain('Associateds.Users')
            ->where(['property_id' => $propertyId])
            ->where(['locator_1' => $property['locator_id']]);

        $sum = 0;
        foreach ($associations as $a) {
            $sum += $a['porcentagem'];
        }

        $ownerPercentage = 100 - $sum;

        $this->set(compact('ownerPercentage'));

        if ($this->request->is('post')) {
            $this->LocatorsAssociations->deleteAll(['locator_1' => $property['locator_id']]);
            $this->LocatorsAssociations->deleteAll(['locator_2' => $property['locator_id']]);

            if (!empty($this->request->getData('slider'))) {
                $sum = 0;
                foreach ($this->request->getData('slider') as $key => $v) {
                    $sum += $v;
                }

                $ownerPercentage = 100 - $sum;

                foreach ($this->request->getData('slider') as $key => $v) {
                    $locatorAssociation = $this->LocatorsAssociations->newEntity();

                    $locatorAssociation['locator_1'] = $property['locator_id'];
                    $locatorAssociation['locator_2'] = $key;
                    $locatorAssociation['property_id'] = $propertyId;
                    $locatorAssociation['porcentagem'] = $v;

                    $this->LocatorsAssociations->save($locatorAssociation);

                    $locatorAssociation = $this->LocatorsAssociations->newEntity();

                    $locatorAssociation['locator_1'] = $key;
                    $locatorAssociation['locator_2'] = $property['locator_id'];
                    $locatorAssociation['property_id'] = $propertyId;
                    $locatorAssociation['porcentagem'] = $ownerPercentage;

                    $this->LocatorsAssociations->save($locatorAssociation);
                }
            }

            $this->Flash->success('Salvo com sucesso');

            $this->redirect(['controller' => 'properties', 'action' => 'view', $propertyId]);
        }

        $this->set(compact('associations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Locators Association id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locatorsAssociation = $this->LocatorsAssociations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locatorsAssociation = $this->LocatorsAssociations->patchEntity($locatorsAssociation, $this->request->getData());
            if ($this->LocatorsAssociations->save($locatorsAssociation)) {
                $this->Flash->success(__('The locators association has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The locators association could not be saved. Please, try again.'));
        }
        $this->set(compact('locatorsAssociation'));
        $this->set('_serialize', ['locatorsAssociation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Locators Association id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locatorsAssociation = $this->LocatorsAssociations->get($id);
        if ($this->LocatorsAssociations->delete($locatorsAssociation)) {
            $this->Flash->success(__('The locators association has been deleted.'));
        } else {
            $this->Flash->error(__('The locators association could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
