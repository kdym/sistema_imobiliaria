<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExtractsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExtractsTable Test Case
 */
class ExtractsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExtractsTable
     */
    public $Extracts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.extracts',
        'app.properties',
        'app.locators',
        'app.users',
        'app.brokers',
        'app.tenants',
        'app.prosecutors',
        'app.locators_associations',
        'app.associateds',
        'app.properties_compositions',
        'app.properties_fees',
        'app.properties_prices',
        'app.contracts',
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
        $config = TableRegistry::exists('Extracts') ? [] : ['className' => ExtractsTable::class];
        $this->Extracts = TableRegistry::get('Extracts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Extracts);

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
