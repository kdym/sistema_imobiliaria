<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Policy\CompanyDataPolicy;

/**
 * CompanyData Controller
 *
 * @property \App\Model\Table\CompanyDataTable $CompanyData
 *
 * @method \App\Model\Entity\CompanyData[] paginate($object = null, array $settings = [])
 */
class CompanyDataController extends AppController
{

    function isAuthorized($user)
    {
//        $element = $this->Users->findById($this->request->getParam('pass.0'))
//            ->applyOptions(['withDeleted'])
//            ->first();

        return CompanyDataPolicy::isAuthorized($this->request->action, $user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $companyData = $this->CompanyData->find()->first();

        $entity = ($companyData) ? $companyData : $this->CompanyData->newEntity();

        if ($this->request->is(['post', 'put'])) {
            $this->CompanyData->patchEntity($entity, $this->request->getData());

            if ($this->CompanyData->save($entity)) {
                $this->Flash->success('Salvo com sucesso');

                $this->redirect(['action' => 'index']);
            }
        }

        $this->set('companyData', $entity);
    }

    /**
     * View method
     *
     * @param string|null $id Company Data id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companyData = $this->CompanyData->get($id, [
            'contain' => []
        ]);

        $this->set('companyData', $companyData);
        $this->set('_serialize', ['companyData']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $companyData = $this->CompanyData->newEntity();
        if ($this->request->is('post')) {
            $companyData = $this->CompanyData->patchEntity($companyData, $this->request->getData());
            if ($this->CompanyData->save($companyData)) {
                $this->Flash->success(__('The company data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company data could not be saved. Please, try again.'));
        }
        $this->set(compact('companyData'));
        $this->set('_serialize', ['companyData']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Company Data id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $companyData = $this->CompanyData->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companyData = $this->CompanyData->patchEntity($companyData, $this->request->getData());
            if ($this->CompanyData->save($companyData)) {
                $this->Flash->success(__('The company data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company data could not be saved. Please, try again.'));
        }
        $this->set(compact('companyData'));
        $this->set('_serialize', ['companyData']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Data id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyData = $this->CompanyData->get($id);
        if ($this->CompanyData->delete($companyData)) {
            $this->Flash->success(__('The company data has been deleted.'));
        } else {
            $this->Flash->error(__('The company data could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteLogo()
    {
        if (unlink(WWW_ROOT . '/file/logo.png')) {
            $this->Flash->success('Logo excluído');

            $this->redirect($this->referer());
        }
    }

    public function deleteSmallLogo()
    {
        if (unlink(WWW_ROOT . '/file/logo_small.png')) {
            $this->Flash->success('Logo Pequeno excluído');

            $this->redirect($this->referer());
        }
    }
}
