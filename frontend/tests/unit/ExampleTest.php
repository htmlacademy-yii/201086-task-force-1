<?php
namespace frontend\tests;

use frontend\services\Test;

class ExampleTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testCorrectSumFeature()
    {
        $this->assertEquals(Test::sum(4,5), 9);
    }

    public function testNotCorrectSumFeature()
    {
        $this->assertNotEquals(Test::sum(4,5), 10);
    }
}
