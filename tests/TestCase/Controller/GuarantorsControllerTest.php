<?php
namespace App\Test\TestCase\Controller;

use App\Controller\GuarantorsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\GuarantorsController Test Case
 */
class GuarantorsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.guarantors',
        'app.users',
        'app.brokers',
        'app.locators',
        'app.locators_associations',
        'app.properties',
        'app.properties_compositions',
        'app.properties_fees',
        'app.properties_prices',
        'app.properties_photos',
        'app.contracts',
        'app.tenants',
        'app.active_contract',
        'app.contracts_values',
        'app.associateds',
        'app.prosecutors',
        'app.spouses'
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
