<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\GlobalCombosHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\GlobalCombosHelper Test Case
 */
class GlobalCombosHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\GlobalCombosHelper
     */
    public $GlobalCombos;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->GlobalCombos = new GlobalCombosHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GlobalCombos);

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
