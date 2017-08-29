<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\VersionHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\VersionHelper Test Case
 */
class VersionHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\VersionHelper
     */
    public $Version;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Version = new VersionHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Version);

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
