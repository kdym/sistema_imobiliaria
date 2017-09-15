<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProsecutorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProsecutorsTable Test Case
 */
class ProsecutorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProsecutorsTable
     */
    public $Prosecutors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.prosecutors',
        'app.users',
        'app.brokers',
        'app.locators',
        'app.locators_associations',
        'app.associateds'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Prosecutors') ? [] : ['className' => ProsecutorsTable::class];
        $this->Prosecutors = TableRegistry::get('Prosecutors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Prosecutors);

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
