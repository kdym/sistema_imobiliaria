<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractsTable Test Case
 */
class ContractsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContractsTable
     */
    public $Contracts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Contracts') ? [] : ['className' => ContractsTable::class];
        $this->Contracts = TableRegistry::get('Contracts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Contracts);

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
