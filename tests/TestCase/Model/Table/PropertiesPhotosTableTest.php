<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PropertiesPhotosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PropertiesPhotosTable Test Case
 */
class PropertiesPhotosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PropertiesPhotosTable
     */
    public $PropertiesPhotos;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PropertiesPhotos') ? [] : ['className' => PropertiesPhotosTable::class];
        $this->PropertiesPhotos = TableRegistry::get('PropertiesPhotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PropertiesPhotos);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
