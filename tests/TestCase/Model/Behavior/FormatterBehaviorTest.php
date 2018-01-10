<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\FormatterBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\FormatterBehavior Test Case
 */
class FormatterBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\FormatterBehavior
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
        $this->Formatter = new FormatterBehavior();
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
