<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use App\Policy\UsersPolicy;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\PropertiesTable $Properties
 * @property \App\Model\Table\LocatorsAssociationsTable $LocatorsAssociations
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadComponent('GraphUtil');

        $this->loadModel('Properties');
        $this->loadModel('LocatorsAssociations');

        $this->Auth->allow(['firstUser', 'notAuthorized']);
    }

    function isAuthorized($user)
    {
        $element = $this->Users->findById($this->request->getParam('pass.0'))
            ->applyOptions(['withDeleted'])
            ->first();

        return UsersPolicy::isAuthorized($this->request->action, $user, $element);
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event); // TODO: Change the autogenerated stub

        $this->viewBuilder()->setHelpers(['Users', 'Brokers', 'Locators', 'Properties']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->Users->find()
            ->applyOptions(['withDeleted']);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [
                'Spouses',
                'Brokers',
                'Locators' => [
                    'LocatorsAssociations.Associateds.Users',
                    'Prosecutors.Users',
                ],
                'Prosecutors.Locators.Users',
                'Tenants.ActiveContract.Properties'
            ],
            'withDeleted'
        ]);

        $properties = [];

        $query = $this->Properties->find()
            ->contain('Locators.Users')
            ->where(['broker' => $id])
            ->limit(8);

        if (!$query->isEmpty()) {
            $properties = $this->paginate($query);
        }

        if ($user['role'] == UsersTable::ROLE_LOCATOR) {
            $queryProperties = $this->Properties->find()
                ->select(TableRegistry::get('Properties'))
                ->select(TableRegistry::get('Locators'))
                ->select(TableRegistry::get('Users'))
                ->contain('Locators.Users')
                ->where(['locator_id' => $user['locator']['id']]);

            $queryAssociateds = $this->LocatorsAssociations->find()
                ->select(TableRegistry::get('Properties'))
                ->select(TableRegistry::get('Locators'))
                ->select(TableRegistry::get('Users'))
                ->contain('Properties.Locators.Users')
                ->where(['locator_1' => $user['locator']['id']]);

            $query = $queryProperties->union($queryAssociateds)->limit(8);

            if (!$query->isEmpty()) {
                $properties = $this->paginate($query);
            }
        }

        $this->set(compact('user', 'properties'));
    }

    public function form($id = null)
    {
        $this->set(compact('id'));

        if ($id) {
            $user = $this->Users->get($id);
        } else {
            $user = $this->Users->newEntity();
        }

        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success('Salvo com sucesso');

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Existem erros no formulário, favor verificar');
            }
        }

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);

        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Usuário excluído'));
        } else {
            $this->Flash->error(__('Erro ao excluir Usuário'));
        }

        return $this->redirect($this->referer());
    }

    public function undelete($id)
    {
        $this->request->allowMethod(['put']);

        $user = $this->Users->get($id, ['withDeleted']);

        if ($this->Users->restore($user)) {
            $this->Flash->success(__('Usuário reativado'));
        } else {
            $this->Flash->error(__('Erro ao reativar Usuário'));
        }

        return $this->redirect($this->referer());
    }

    public function login()
    {
        $users = $this->Users->find();

        if ($users->isEmpty()) {
            $this->Flash->set('Nenhum usuário cadastrado no sistema, favor cadastrar seu primeiro usuário');

            $this->redirect(['action' => 'firstUser']);
        }

        $this->viewBuilder()->setLayout("login");

        $usuario = $this->Users->newEntity();

        if (!$this->request->is("get")) {
            if (is_numeric($this->request->data["username"])) {
                $this->request->data["username"] = (int)$this->request->data["username"];
                $this->request->data["username"] = (string)$this->request->data["username"];
            }

            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error('Login inválido');
            }
        }

        $this->set(compact("usuario"));
    }

    public function firstUser()
    {
        $this->viewBuilder()->setLayout("login");

        $users = $this->Users->find();

        if (!$users->isEmpty()) {
            $this->redirect(['action' => 'notAuthorized']);
        }

        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $this->Users->patchEntity($user, $this->request->getData());

            $user['role'] = UsersTable::ROLE_ADMIN;

            if ($this->Users->save($user)) {
                $auth = $this->Auth->identify();

                if ($auth) {
                    $this->Auth->setUser($auth);

                    $this->redirect('/');
                }
            }
        }

        $this->set(compact('user'));
    }

    public function notAuthorized()
    {
        $this->viewBuilder()->setLayout('login');
    }

    public function logout()
    {
        if ($this->Auth->logout()) {
            $this->redirect("/");
        }
    }

    public function profile()
    {
        $user = $this->Users->get($this->Auth->user('id'));

        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success('Salvo com sucesso');

                return $this->redirect(['action' => 'profile']);
            } else {
                $this->Flash->error('Existem erros no formulário, favor verificar');
            }
        }

        $this->set(compact('user'));
    }

    public function fetch()
    {
        $this->autoRender = false;
        $this->response->type('json');

        $search = $this->Users->parseSearch($this->Users->parseUsername($this->request->getQuery('name')));

        $locators = $this->Users->find()
            ->where([
                "OR" => [
                    "Users.nome LIKE" => $search,
                    "Users.username LIKE" => $search,
                ],
            ])
            ->limit(10);

        $this->response->body(json_encode($locators));
    }
}
