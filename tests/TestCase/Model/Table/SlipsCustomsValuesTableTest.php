<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SlipsCustomsValuesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SlipsCustomsValuesTable Test Case
 */
class SlipsCustomsValuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SlipsCustomsValuesTable
     */
    public $SlipsCustomsValues;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SlipsCustomsValues') ? [] : ['className' => SlipsCustomsValuesTable::class];
        $this->SlipsCustomsValues = TableRegistry::get('SlipsCustomsValues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SlipsCustomsValues);

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
