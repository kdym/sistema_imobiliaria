<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompanyDataTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompanyDataTable Test Case
 */
class CompanyDataTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CompanyDataTable
     */
    public $CompanyData;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.company_data'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CompanyData') ? [] : ['className' => CompanyDataTable::class];
        $this->CompanyData = TableRegistry::get('CompanyData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CompanyData);

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
