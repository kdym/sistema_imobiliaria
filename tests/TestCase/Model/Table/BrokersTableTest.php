<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BrokersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BrokersTable Test Case
 */
class BrokersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BrokersTable
     */
    public $Brokers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.brokers',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Brokers') ? [] : ['className' => BrokersTable::class];
        $this->Brokers = TableRegistry::get('Brokers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Brokers);

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
