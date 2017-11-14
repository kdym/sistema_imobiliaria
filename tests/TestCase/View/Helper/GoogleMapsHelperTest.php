<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\GoogleMapsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\GoogleMapsHelper Test Case
 */
class GoogleMapsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\GoogleMapsHelper
     */
    public $GoogleMaps;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->GoogleMaps = new GoogleMapsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GoogleMaps);

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
