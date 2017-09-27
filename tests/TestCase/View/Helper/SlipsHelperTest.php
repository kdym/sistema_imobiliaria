<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\SlipsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\SlipsHelper Test Case
 */
class SlipsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\SlipsHelper
     */
    public $Slips;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Slips = new SlipsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Slips);

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
