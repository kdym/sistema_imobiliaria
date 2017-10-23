<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ConfigHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ConfigHelper Test Case
 */
class ConfigHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\ConfigHelper
     */
    public $Config;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Config = new ConfigHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Config);

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
