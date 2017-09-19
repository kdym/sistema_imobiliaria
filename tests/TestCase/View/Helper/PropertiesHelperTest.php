<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\PropertiesHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\PropertiesHelper Test Case
 */
class PropertiesHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\PropertiesHelper
     */
    public $Properties;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Properties = new PropertiesHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Properties);

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
