<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PropertiesFeesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PropertiesFeesTable Test Case
 */
class PropertiesFeesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PropertiesFeesTable
     */
    public $PropertiesFees;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.properties_fees',
        'app.properties',
        'app.locators',
        'app.users',
        'app.brokers',
        'app.prosecutors',
        'app.locators_associations',
        'app.associateds',
        'app.properties_compositions',
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
        $config = TableRegistry::exists('PropertiesFees') ? [] : ['className' => PropertiesFeesTable::class];
        $this->PropertiesFees = TableRegistry::get('PropertiesFees', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PropertiesFees);

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