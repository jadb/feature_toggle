<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle;

use FeatureToggle\Feature\TestFeature;
use FeatureToggle\Strategy\DateTimeRangeStrategy;

/**
 * DateTimeRange strategy test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Strategy\DateTimeRangeStrategy
 */
class DateTimeRangeStrategyTest extends \PHPUnit_Framework_TestCase
{
    private $Strategy;
    public function setUp()
    {
        $this->Strategy = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeRangeStrategy',
            array('asDateTimeStrategy'),
            array('2014-01-01', '2014-12-31', true)
        );
    }

    public function tearDown()
    {
        unset($this->Strategy);
    }
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $this->assertObjectHasAttribute('inclusive', $this->Strategy);
        $this->assertObjectHasAttribute('minRange', $this->Strategy);
        $this->assertObjectHasAttribute('maxRange', $this->Strategy);
    }

    /**
     * @covers ::__invoke
     */
    public function testInvoke()
    {
        $Feature = new TestFeature('foo');

        $DateTimeStrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('__invoke'),
            array('2013-03-01')
        );

        $this->Strategy->expects($this->at(0))
            ->method('asDateTimeStrategy')
            ->with('2014-01-01', '>=')
            ->will($this->returnValue($DateTimeStrategyMock));

        $this->Strategy->expects($this->at(1))
            ->method('asDateTimeStrategy')
            ->with('2014-12-31', '<=')
            ->will($this->returnValue($DateTimeStrategyMock));

        $DateTimeStrategyMock->expects($this->exactly(2))
            ->method('__invoke')
            ->with($Feature)
            ->will($this->returnValue(false));

        $this->assertFalse(call_user_func($this->Strategy, $Feature));
    }

    public function testAsDateTimeStrategy()
    {
        $Strategy = new DateTimeRangeStrategy('2014-01-01', '2014-12-31');

        $expected = new \FeatureToggle\Strategy\DateTimeStrategy('2014-01-01', '>');
        $actual = $Strategy->asDateTimeStrategy('2014-01-01', '>');
        $this->assertEquals($expected, $actual);
    }
}
