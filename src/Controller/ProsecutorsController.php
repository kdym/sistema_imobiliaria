<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use App\Policy\ProsecutorsPolicy;

/**
 * Prosecutors Controller
 *
 * @property \App\Model\Table\ProsecutorsTable $Prosecutors
 * @property \App\Model\Table\LocatorsTable $Locators
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\Prosecutor[] paginate($object = null, array $settings = [])
 */
class ProsecutorsController extends AppController
{

    function isAuthorized($user)
    {
        $element = $this->Prosecutors->findById($this->request->getParam('pass.0'))
            ->first();

        return ProsecutorsPolicy::isAuthorized($this->request->action, $user, $element);
    }

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadModel('Locators');
        $this->loadModel('Users');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Locators']
        ];
        $prosecutors = $this->paginate($this->Prosecutors);

        $this->set(compact('prosecutors'));
        $this->set('_serialize', ['prosecutors']);
    }

    /**
     * View method
     *
     * @param string|null $id Prosecutor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $prosecutor = $this->Prosecutors->get($id, [
            'contain' => ['Users', 'Locators']
        ]);

        $this->set('prosecutor', $prosecutor);
        $this->set('_serialize', ['prosecutor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $prosecutor = $this->Prosecutors->newEntity();
        if ($this->request->is('post')) {
            $prosecutor = $this->Prosecutors->patchEntity($prosecutor, $this->request->getData());
            if ($this->Prosecutors->save($prosecutor)) {
                $this->Flash->success(__('The prosecutor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The prosecutor could not be saved. Please, try again.'));
        }
        $users = $this->Prosecutors->Users->find('list', ['limit' => 200]);
        $locators = $this->Prosecutors->Locators->find('list', ['limit' => 200]);
        $this->set(compact('prosecutor', 'users', 'locators'));
        $this->set('_serialize', ['prosecutor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Prosecutor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $prosecutor = $this->Prosecutors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $prosecutor = $this->Prosecutors->patchEntity($prosecutor, $this->request->getData());
            if ($this->Prosecutors->save($prosecutor)) {
                $this->Flash->success(__('The prosecutor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The prosecutor could not be saved. Please, try again.'));
        }
        $users = $this->Prosecutors->Users->find('list', ['limit' => 200]);
        $locators = $this->Prosecutors->Locators->find('list', ['limit' => 200]);
        $this->set(compact('prosecutor', 'users', 'locators'));
        $this->set('_serialize', ['prosecutor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Prosecutor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('delete');

        $prosecutor = $this->Prosecutors->get($id);
        if ($this->Prosecutors->delete($prosecutor)) {
            $this->Flash->success(__('Excluído com sucesso'));
        }

        return $this->redirect($this->referer());
    }

    public function form($locatorId, $id = null)
    {
        $locator = $this->Locators->get($locatorId, ['contain' => ['Users']]);

        $this->set(compact('locator', 'id'));

        if (!$id) {
            $prosecutor = $this->Users->newEntity();
        } else {
            $prosecutorAssociation = $this->Prosecutors->get($id);
            $prosecutor = $this->Users->get($prosecutorAssociation['user_id']);
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($prosecutor, $this->request->getData());

            if (!$id) {
                $prosecutor['role'] = UsersTable::ROLE_PROSECUTOR;
                $prosecutor['username'] = $this->Users->getLastUsername() + 1;
            }

            if ($this->Users->save($prosecutor)) {
                if (!$id) {
                    $prosecutorLink = $this->Prosecutors->newEntity();

                    $prosecutorLink['user_id'] = $prosecutor['id'];
                    $prosecutorLink['locator_id'] = $locatorId;

                    $this->Prosecutors->save($prosecutorLink);
                }

                $this->Flash->success('Procurador salvo com sucesso');

                $this->redirect(['controller' => 'users', 'action' => 'view', $locator['user']['id']]);
            }
        }

        $this->set(compact('prosecutor'));
    }

    public function addExisting()
    {
        $this->autoRender = false;
        $this->response->type('json');

        $this->request->allowMethod('post');

        $exists = $this->Prosecutors->find()
            ->where(['user_id' => $this->request->getData('user_id')])
            ->where(['locator_id' => $this->request->getData('locator_id')])
            ->first();

        if (!$exists) {
            $prosecutor = $this->Prosecutors->newEntity();

            $prosecutor['user_id'] = $this->request->getData('user_id');
            $prosecutor['locator_id'] = $this->request->getData('locator_id');

            $this->Prosecutors->save($prosecutor);

            $this->Flash->success('Procurador salvo com sucesso');

            $response = 'ok';
        } else {
            $response = 'exists';
        }

        $this->response->body(json_encode($response));
    }
}