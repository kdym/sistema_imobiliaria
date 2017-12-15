<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GuarantorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GuarantorsTable Test Case
 */
class GuarantorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GuarantorsTable
     */
    public $Guarantors;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Guarantors') ? [] : ['className' => GuarantorsTable::class];
        $this->Guarantors = TableRegistry::get('Guarantors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Guarantors);

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
