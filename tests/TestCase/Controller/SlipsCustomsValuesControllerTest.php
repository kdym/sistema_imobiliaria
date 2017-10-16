<?php
namespace App\Test\TestCase\Controller;

use App\Controller\SlipsCustomsValuesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\SlipsCustomsValuesController Test Case
 */
class SlipsCustomsValuesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.slips_customs_values',
        'app.contracts',
        'app.tenants',
        'app.users',
        'app.brokers',
        'app.locators',
        'app.locators_associations',
        'app.associateds',
        'app.prosecutors',
        'app.properties',
        'app.properties_compositions',
        'app.properties_fees',
        'app.properties_prices',
        'app.contracts_values'
    ];

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
