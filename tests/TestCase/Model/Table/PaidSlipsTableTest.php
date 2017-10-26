<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PaidSlipsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PaidSlipsTable Test Case
 */
class PaidSlipsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PaidSlipsTable
     */
    public $PaidSlips;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.paid_slips',
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
        $config = TableRegistry::exists('PaidSlips') ? [] : ['className' => PaidSlipsTable::class];
        $this->PaidSlips = TableRegistry::get('PaidSlips', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PaidSlips);

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
