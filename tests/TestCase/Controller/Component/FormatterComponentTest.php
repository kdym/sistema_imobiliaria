<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\FormatterComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\FormatterComponent Test Case
 */
class FormatterComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\FormatterComponent
     */
    public $Formatter;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Formatter = new FormatterComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Formatter);

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
