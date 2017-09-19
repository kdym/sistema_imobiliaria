<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\GoogleMapsComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\GoogleMapsComponent Test Case
 */
class GoogleMapsComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\GoogleMapsComponent
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
        $registry = new ComponentRegistry();
        $this->GoogleMaps = new GoogleMapsComponent($registry);
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
