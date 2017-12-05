<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PropertiesPhotosController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\PropertiesPhotosController Test Case
 */
class PropertiesPhotosControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.properties_photos',
        'app.properties',
        'app.locators',
        'app.users',
        'app.brokers',
        'app.tenants',
        'app.active_contract',
        'app.contracts_values',
        'app.contracts',
        'app.prosecutors',
        'app.locators_associations',
        'app.associateds',
        'app.properties_compositions',
        'app.properties_fees',
        'app.properties_prices'
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
