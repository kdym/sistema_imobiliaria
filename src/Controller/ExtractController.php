<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Custom\Extract;
use App\Model\Custom\ExtractPropertyValue;
use App\Policy\ExtractPolicy;
use Cake\Event\Event;
use DateInterval;
use DatePeriod;
use DateTime;

/**
 * Extract Controller
 *
 * @property \App\Model\Table\ExtractsTable $Extracts
 * @property \App\Model\Table\LocatorsTable $Locators
 *
 */
class ExtractController extends AppController
{

    function isAuthorized($user)
    {
        return ExtractPolicy::isAuthorized($this->request->action, $user);
    }

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->loadModel('Extracts');
        $this->loadModel('Locators');
        $this->loadModel('Contracts');
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event); // TODO: Change the autogenerated stub

        $this->viewBuilder()->setHelpers(['Slips']);
    }

    public function index($locatorId)
    {
        $locator = $this->Locators->get($locatorId, [
            'contain' => ['Users', 'Properties.ActiveContract.Tenants.Users']
        ]);

        $this->set(compact('locator'));

        $startDate = new DateTime('now');
        $endDate = new DateTime('now');

        if (!empty($this->request->getQuery('start_date'))) {
            $startDate = new DateTime($this->Contracts->parseDate($this->request->getQuery('start_date')));
        }

        if (!empty($this->request->getQuery('end_date'))) {
            $endDate = new DateTime($this->Contracts->parseDate($this->request->getQuery('end_date')));
        }

        $startDate->modify('first day of this month');
        $endDate->modify('last day of this month');

        $this->set(compact('startDate', 'endDate'));

        $extracts = $this->findExtractsInPeriod($locator, $endDate);

        $this->set(compact('extracts'));
    }

    public function findExtractsInPeriod($locator, DateTime $endDate)
    {
        $created = new DateTime($locator['user']['created']->format('Y-m-d'));

        $created->modify('first day of this month');

        $extracts = [];
        foreach ($locator['properties'] as $p) {
            $allExtractsQuery = $this->Extracts->find()
                ->where(['property_id' => $p['id']])
                ->where(['data between :start_date and :end_date'])
                ->bind(':start_date', $created->format('Y-m-d'))
                ->bind(':end_date', $endDate->format('Y-m-d'));

            foreach ($allExtractsQuery as $e) {
                $extracts[$e['data']->format('Y-m')][$e['property_id']][] = $e;
            }
        }

        return $extracts;
    }
}
