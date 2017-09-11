<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\LocatorsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\LocatorsHelper Test Case
 */
class LocatorsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\LocatorsHelper
     */
    public $Locators;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Locators = new LocatorsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Locators);

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
