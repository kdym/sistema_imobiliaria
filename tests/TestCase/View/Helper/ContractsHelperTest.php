<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ContractsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ContractsHelper Test Case
 */
class ContractsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\ContractsHelper
     */
    public $Contracts;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Contracts = new ContractsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Contracts);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
