<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecursiveTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecursiveTable Test Case
 */
class RecursiveTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RecursiveTable
     */
    public $Recursive;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.recursive',
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
        $config = TableRegistry::exists('Recursive') ? [] : ['className' => RecursiveTable::class];
        $this->Recursive = TableRegistry::get('Recursive', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Recursive);

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
}
