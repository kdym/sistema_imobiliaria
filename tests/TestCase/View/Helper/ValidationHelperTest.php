<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ValidationHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ValidationHelper Test Case
 */
class ValidationHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\ValidationHelper
     */
    public $Validation;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Validation = new ValidationHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Validation);

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
