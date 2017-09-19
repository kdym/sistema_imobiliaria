<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\PaginationHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\PaginationHelper Test Case
 */
class PaginationHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\PaginationHelper
     */
    public $Pagination;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Pagination = new PaginationHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pagination);

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
