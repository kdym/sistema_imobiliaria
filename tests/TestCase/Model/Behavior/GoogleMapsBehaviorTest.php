<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\GoogleMapsBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\GoogleMapsBehavior Test Case
 */
class GoogleMapsBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\GoogleMapsBehavior
     */
    public $GoogleMaps;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->GoogleMaps = new GoogleMapsBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GoogleMaps);

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
