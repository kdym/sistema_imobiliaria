<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\CompanyDataHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\CompanyDataHelper Test Case
 */
class CompanyDataHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\CompanyDataHelper
     */
    public $CompanyData;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->CompanyData = new CompanyDataHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CompanyData);

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
