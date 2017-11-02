<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\PropertiesCompositionsTable;
use App\Policy\PropertiesPolicy;
use Cake\Event\Event;

/**
 * Properties Controller
 *
 * @property \App\Model\Table\PropertiesTable $Properties
 * @property \App\Model\Table\PropertiesCompositionsTable $PropertiesCompositions
 * @property \App\Model\Table\PropertiesFeesTable $PropertiesFees
 * @property \App\Model\Table\PropertiesPricesTable $PropertiesPrices
 *
 * @method \App\Model\Entity\Property[] paginate($object = null, array $settings = [])
 */
class PropertiesController extends AppController
{

    function isAuthorized($user)
    {
//        $element = $this->Users->findById($this->request->getParam('pass.0'))
//            ->first();

        return PropertiesPolicy::isAuthorized($this->request->action, $user);
    }

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadComponent('GoogleMaps');
        $this->loadComponent('Formatter');

        $this->loadModel('PropertiesCompositions');
        $this->loadModel('PropertiesFees');
        $this->loadModel('PropertiesPrices');
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event); // TODO: Change the autogenerated stub

        $this->viewBuilder()->setHelpers(['Properties', 'Pagination']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'order' => ['id' => 'desc'],
            'contain' => ['Locators.Users'],
            'limit' => 8,
        ];
        $properties = $this->paginate($this->Properties);

        $this->set(compact('properties'));
        $this->set('_serialize', ['properties']);
    }

    /**
     * View method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $property = $this->Properties->get($id, [
            'contain' => [
                'Locators.Users',
                'PropertiesCompositions',
                'PropertiesFees',
                'PropertiesPrices',
            ]
        ]);

        $this->set('property', $property);
        $this->set('_serialize', ['property']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $property = $this->Properties->newEntity();
        if ($this->request->is('post')) {
            $property = $this->Properties->patchEntity($property, $this->request->getData());
            if ($this->Properties->save($property)) {
                $this->Flash->success(__('The property has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The property could not be saved. Please, try again.'));
        }
        $locators = $this->Properties->Locators->find('list', ['limit' => 200]);
        $this->set(compact('property', 'locators'));
        $this->set('_serialize', ['property']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $property = $this->Properties->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $property = $this->Properties->patchEntity($property, $this->request->getData());
            if ($this->Properties->save($property)) {
                $this->Flash->success(__('The property has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The property could not be saved. Please, try again.'));
        }
        $locators = $this->Properties->Locators->find('list', ['limit' => 200]);
        $this->set(compact('property', 'locators'));
        $this->set('_serialize', ['property']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('delete');

        $property = $this->Properties->get($id);
        if ($this->Properties->delete($property)) {
            $this->Flash->success(__('Excluído com sucesso'));
        } else {
            $this->Flash->error(__('The property could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function form($id = null)
    {
        if (!$id) {
            $property = $this->Properties->newEntity();
        } else {
            $property = $this->Properties->get($id, [
                'contain' => [
                    'Locators.Users',
                    'PropertiesCompositions',
                    'PropertiesFees',
                    'PropertiesPrices',
                ]
            ]);
        }

        if ($this->request->is('get')) {
            if (!empty($property['properties_compositions'][0])) {
                foreach (PropertiesCompositionsTable::$propertiesItems as $i) {
                    $property[$i->getKey()] = $property['properties_compositions'][0][$i->getKey()];
                }

                foreach (PropertiesCompositionsTable::$compositions as $key => $c) {
                    $property[$key] = $property['properties_compositions'][0][$key];
                }
            }

            if (!empty($property['properties_prices'][0])) {
                $property['valor'] = $this->Formatter->formatDecimal($property['properties_prices'][0]['valor']);
            }

            if (!empty($property['properties_fees'][0])) {
                $property['taxa_administrativa'] = $this->Formatter->formatDecimal($property['properties_fees'][0]['taxa_administrativa']);
                $property['taxa_administrativa_tipo'] = $property['properties_fees'][0]['taxa_administrativa_tipo'];
                $property['taxa_administrativa_incidencia'] = $property['properties_fees'][0]['taxa_administrativa_incidencia'];
                $property['parcelas_13_taxa_administrativa'] = $property['properties_fees'][0]['parcelas_13_taxa_administrativa'];
            }

            if (!empty($property['locator'])) {
                $property['locator_search'] = sprintf('%s - %s', $property['locator']['user']['nome'], $property['locator']['user']['formatted_username']);
            }
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Properties->patchEntity($property, $this->request->getData());

            $geoInfo = $this->GoogleMaps->getGeoInfo(implode(' ', array_filter([
                $property['endereco'],
                $property['numero'],
                $property['complemento'],
                $property['bairro'],
                $property['cidade'],
                $property['uf'],
                $property['cep'],
            ])));

            $property['latitude'] = $geoInfo['latitude'];
            $property['longitude'] = $geoInfo['longitude'];

            if ($this->Properties->save($property)) {
                $propertyComposition = $this->PropertiesCompositions->newEntity();

                foreach (PropertiesCompositionsTable::$propertiesItems as $i) {
                    $propertyComposition[$i->getKey()] = $property[$i->getKey()];
                }

                foreach (PropertiesCompositionsTable::$compositions as $key => $c) {
                    $propertyComposition[$key] = $property[$key];
                }

                $propertyComposition['start_date'] = date('Y-m-d');
                $propertyComposition['property_id'] = $property['id'];

                if ($this->PropertiesCompositions->save($propertyComposition)) {
                    $propertyFees = $this->PropertiesFees->newEntity();

                    $propertyFees['taxa_administrativa'] = $this->Properties->parseDecimal($property['taxa_administrativa']);
                    $propertyFees['taxa_administrativa_tipo'] = $property['taxa_administrativa_tipo'];
                    $propertyFees['taxa_administrativa_incidencia'] = $property['taxa_administrativa_incidencia'];
                    $propertyFees['parcelas_13_taxa_administrativa'] = $property['parcelas_13_taxa_administrativa'];
                    $propertyFees['start_date'] = date('Y-m-d');
                    $propertyFees['property_id'] = $property['id'];

                    if ($this->PropertiesFees->save($propertyFees)) {
                        $propertyPrice = $this->PropertiesPrices->newEntity();

                        $propertyPrice['valor'] = $this->Properties->parseDecimal($property['valor']);
                        $propertyPrice['start_date'] = date('Y-m-d');
                        $propertyPrice['property_id'] = $property['id'];

                        if ($this->PropertiesPrices->save($propertyPrice)) {
                            $this->Flash->success('Salvo com sucesso');

                            $this->redirect(['action' => 'view', $property['id']]);
                        }
                    }
                }
            }
        }

        $this->set(compact('property'));
    }

    public function fetch()
    {
        $this->autoRender = false;
        $this->response->type('json');

        $search = $this->Properties->parseSearch($this->Properties->parseCode($this->request->getQuery('name')));

        $properties = $this->Properties->find()
            ->contain('Locators.Users')
            ->where([
                "OR" => [
                    "Properties.id LIKE" => $search,
                    "Properties.endereco LIKE" => $search,
                    "Properties.numero LIKE" => $search,
                    "Properties.complemento LIKE" => $search,
                    "Properties.bairro LIKE" => $search,
                    "Properties.cidade LIKE" => $search,
                    "Properties.uf LIKE" => $search,
                ],
            ])
            ->limit(10);

        $this->response->body(json_encode($properties));
    }
}
