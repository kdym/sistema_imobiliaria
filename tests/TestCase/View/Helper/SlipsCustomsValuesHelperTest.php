<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\SlipsCustomsValuesHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\SlipsCustomsValuesHelper Test Case
 */
class SlipsCustomsValuesHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\SlipsCustomsValuesHelper
     */
    public $SlipsCustomsValues;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->SlipsCustomsValues = new SlipsCustomsValuesHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SlipsCustomsValues);

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
