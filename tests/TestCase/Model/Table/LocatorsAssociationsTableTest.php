<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocatorsAssociationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocatorsAssociationsTable Test Case
 */
class LocatorsAssociationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LocatorsAssociationsTable
     */
    public $LocatorsAssociations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.locators_associations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LocatorsAssociations') ? [] : ['className' => LocatorsAssociationsTable::class];
        $this->LocatorsAssociations = TableRegistry::get('LocatorsAssociations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LocatorsAssociations);

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
