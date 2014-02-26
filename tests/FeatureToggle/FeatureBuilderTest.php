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

use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\Feature\TestFeature;
use FeatureToggle\Feature\AbstractFeature;
use FeatureToggle\Strategy\TestStrategy;

/**
 * Test FeatureBuilder class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\FeatureBuilder
 */
class FeatureBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->FeatureBuilder = new FeatureBuilder();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->FeatureBuilder);
    }

    /**
     * @covers ::createFeature
     */
    public function testCreateFeature()
    {
        $expected = new BooleanFeature('Test Feature');
        $actual = $this->FeatureBuilder->createFeature('Test Feature');

        $this->assertEquals($expected, $actual);

        $expected = new TestFeature('Test Feature');
        $actual = $this->FeatureBuilder->createFeature('Test Feature', array('type' => 'test'));

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::addCallback
     * @covers ::setFeature
     */
    public function testAddCallback()
    {
        $callback = function ($Feature) {
            return;
        };

        $FeatureMock = $this->getMock(
            '\FeatureToggle\Feature\BooleanFeature',
            array('pushStrategy'),
            array('Test Feature')
        );

        $FeatureMock->expects($this->once())
            ->method('pushStrategy')
            ->with($callback);

        $this->FeatureBuilder->setFeature($FeatureMock);

        $this->FeatureBuilder->addCallback($callback);
    }

    /**
     * @covers ::addCallback
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage
     */
    public function testAddCallbackThrowsException()
    {
        $this->FeatureBuilder->addCallback('string');
    }

    /**
     * @covers ::addStrategies
     */
    public function testAddStrategies()
    {
        $FeatureBuilderMock = $this->getMock(
            '\FeatureToggle\FeatureBuilder',
            array('addCallback', 'addStrategy')
        );

        $strategies = array(
            function ($Feature) {
                return;
            },
            'Test' => array()
        );

        $FeatureBuilderMock->expects($this->once())->method('addCallback')->with($strategies[0]);
        $FeatureBuilderMock->expects($this->once())->method('addStrategy')->with('Test', $strategies['Test']);

        $FeatureBuilderMock->addStrategies($strategies);
    }

    /**
     * @covers ::addStrategy
     * @covers ::setFeature
     */
    public function testAddStrategy()
    {
        $FeatureMock = $this->getMock(
            '\FeatureToggle\Feature\BooleanFeature',
            array('pushStrategy'),
            array('Test Feature')
        );

        $FeatureMock->expects($this->once())
            ->method('pushStrategy')
            ->with(new TestStrategy());

        $this->FeatureBuilder->setFeature($FeatureMock);

        $this->FeatureBuilder->addStrategy('Test', array());
    }

    /**
     * @covers ::addStrategy
     * @covers ::setFeature
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage
     */
    public function testAddStrategyThrowsExceptionMissingPushStrategyMethod()
    {
        $FeatureMock = $this->getMock('InexistentFeature');
        $this->FeatureBuilder->setFeature($FeatureMock);
        $this->FeatureBuilder->addStrategy('Test', array());
    }

    /**
     * @covers ::addStrategy
     * @covers ::setFeature
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage
     */
    public function testAddStrategyThrowsExceptionBadType()
    {
        $this->FeatureBuilder->setFeature(new BooleanFeature('foo'));
        $this->FeatureBuilder->addStrategy(new TestStrategy(), array());
    }

    /**
     * @covers ::addStrategy
     * @covers ::setFeature
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage
     */
    public function testAddStrategyThrowsExceptionMissingClass()
    {
        $this->FeatureBuilder->setFeature(new BooleanFeature('foo'));
        $this->FeatureBuilder->addStrategy('Inexistent', array());
    }
}
