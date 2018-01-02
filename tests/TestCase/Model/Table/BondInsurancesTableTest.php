<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BondInsurancesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BondInsurancesTable Test Case
 */
class BondInsurancesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BondInsurancesTable
     */
    public $BondInsurances;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bond_insurances',
        'app.contracts',
        'app.tenants',
        'app.users',
        'app.brokers',
        'app.locators',
        'app.locators_associations',
        'app.properties',
        'app.properties_compositions',
        'app.properties_fees',
        'app.properties_prices',
        'app.properties_photos',
        'app.active_contract',
        'app.contracts_values',
        'app.guarantors',
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
        $config = TableRegistry::exists('BondInsurances') ? [] : ['className' => BondInsurancesTable::class];
        $this->BondInsurances = TableRegistry::get('BondInsurances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BondInsurances);

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
