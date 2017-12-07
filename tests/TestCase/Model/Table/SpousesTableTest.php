<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SpousesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SpousesTable Test Case
 */
class SpousesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SpousesTable
     */
    public $Spouses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.spouses',
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
        'app.prosecutors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Spouses') ? [] : ['className' => SpousesTable::class];
        $this->Spouses = TableRegistry::get('Spouses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Spouses);

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
