<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\GraphUtilComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\GraphUtilComponent Test Case
 */
class GraphUtilComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\GraphUtilComponent
     */
    public $GraphUtil;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->GraphUtil = new GraphUtilComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GraphUtil);

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
