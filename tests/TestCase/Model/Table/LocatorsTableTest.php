<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocatorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocatorsTable Test Case
 */
class LocatorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LocatorsTable
     */
    public $Locators;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.locators',
        'app.users',
        'app.brokers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Locators') ? [] : ['className' => LocatorsTable::class];
        $this->Locators = TableRegistry::get('Locators', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Locators);

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
