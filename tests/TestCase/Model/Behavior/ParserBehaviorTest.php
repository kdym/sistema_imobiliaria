<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\ParserBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\ParserBehavior Test Case
 */
class ParserBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\ParserBehavior
     */
    public $Parser;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Parser = new ParserBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Parser);

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
