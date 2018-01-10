<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommonBillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommonBillsTable Test Case
 */
class CommonBillsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CommonBillsTable
     */
    public $CommonBills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.common_bills'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CommonBills') ? [] : ['className' => CommonBillsTable::class];
        $this->CommonBills = TableRegistry::get('CommonBills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CommonBills);

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
