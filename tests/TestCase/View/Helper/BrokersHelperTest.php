<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\BrokersHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\BrokersHelper Test Case
 */
class BrokersHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\BrokersHelper
     */
    public $Brokers;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Brokers = new BrokersHelper($view);
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
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
