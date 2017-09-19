<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PropertiesCompositionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PropertiesCompositionsTable Test Case
 */
class PropertiesCompositionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PropertiesCompositionsTable
     */
    public $PropertiesCompositions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.properties_compositions',
        'app.properties',
        'app.locators',
        'app.users',
        'app.brokers',
        'app.prosecutors',
        'app.locators_associations',
        'app.associateds',
        'app.properties_fees',
        'app.properties_prices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PropertiesCompositions') ? [] : ['className' => PropertiesCompositionsTable::class];
        $this->PropertiesCompositions = TableRegistry::get('PropertiesCompositions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PropertiesCompositions);

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
