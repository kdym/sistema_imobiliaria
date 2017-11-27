<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomBillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomBillsTable Test Case
 */
class CustomBillsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomBillsTable
     */
    public $CustomBills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.custom_bills',
        'app.references'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CustomBills') ? [] : ['className' => CustomBillsTable::class];
        $this->CustomBills = TableRegistry::get('CustomBills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomBills);

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
