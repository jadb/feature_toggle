<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Test\Strategy;

use FeatureToggle\Feature\TestFeature;
use FeatureToggle\Strategy\DateTimeStrategy;

/**
 * DateTime strategy test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Strategy\DateTimeStrategy
 */
class DateTimeStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $Strategy = new DateTimeStrategy('2014-03-01');
        $this->assertObjectHasAttribute('datetime', $Strategy);
        $this->assertObjectHasAttribute('comparator', $Strategy);
    }

    /**
     * @covers ::__invoke
     */
    public function testInvoke()
    {
        // >=
        $datetime = '2014-03-01';
        $now = '2014-02-24';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime)
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertFalse(call_user_func($StrategyMock, new TestFeature('foo')));

        // >=
        $datetime = '2014-03-01';
        $now = '2014-03-01';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime)
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertTrue(call_user_func($StrategyMock, new TestFeature('foo')));

        // ==
        $datetime = '2014-03-01';
        $now = '2014-03-01';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime, '==')
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertTrue(call_user_func($StrategyMock, new TestFeature('foo')));

        // ==
        $datetime = '2014-03-01';
        $now = '2014-03-02';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime, '==')
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertFalse(call_user_func($StrategyMock, new TestFeature('foo')));

        // >
        $datetime = '2014-03-01';
        $now = '2014-03-01';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime, '>')
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertFalse(call_user_func($StrategyMock, new TestFeature('foo')));

        // >
        $datetime = '2014-03-01';
        $now = '2014-02-24';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime, '>')
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertFalse(call_user_func($StrategyMock, new TestFeature('foo')));

        // <
        $datetime = '2014-03-01';
        $now = '2014-02-24';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime, '<')
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertTrue(call_user_func($StrategyMock, new TestFeature('foo')));

        // <
        $datetime = '2014-03-01';
        $now = '2014-03-01';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime, '<')
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertFalse(call_user_func($StrategyMock, new TestFeature('foo')));

        // <=
        $datetime = '2014-03-01';
        $now = '2014-03-01';
        $StrategyMock = $this->getMock(
            '\FeatureToggle\Strategy\DateTimeStrategy',
            array('getCurrentTime'),
            array($datetime, '<=')
        );

        $StrategyMock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(strtotime($now)));

        $this->assertTrue(call_user_func($StrategyMock, new TestFeature('foo')));
    }

    /**
     * @covers ::__invoke
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Bad comparison operator.
     */
    public function testInvokeThrowsException()
    {
        call_user_func(new DateTimeStrategy('2014-03-01', '<>'), new TestFeature('foo'));
    }

    /**
     * @covers ::getCurrentTime
     */
    public function testGetCurrentTime()
    {
        $Strategy = new DateTimeStrategy('2014-03-01');
        $expected = time();
        $actual = $Strategy->getCurrentTime();
        $this->assertEquals($expected, $actual);
    }
}
