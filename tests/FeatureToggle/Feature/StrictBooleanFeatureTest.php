<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Test\Feature;

use FeatureToggle\Feature\StrictBooleanFeature;
use FeatureToggle\Strategy\TestStrategy;

/**
 * Boolean feature test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Feature\BooleanFeature
 */
class StrictBooleanFeatureTest extends \PHPUnit_Framework_TestCase
{
    const FEATURE_NAME = 'Strict Boolean Feature Test';
    const FEATURE_DESC = 'Testing the strict boolean feature class requiring that all strategies pass.';

    private $Feature;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->Feature = new StrictBooleanFeature(self::FEATURE_NAME, self::FEATURE_DESC);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->Feature);
    }

    /**
     * @covers ::__construct
     * @covers ::getDescription
     * @covers ::getName
     * @covers ::getStrategies
     * @covers ::setDescription
     * @covers ::setName
     */
    public function testInheritedMethods()
    {
        $expected = self::FEATURE_NAME;
        $actual = $this->Feature->getName();

        $expected = self::FEATURE_DESC;
        $actual = $this->Feature->getDescription();

        $this->Feature->setName('Foo');
        $expected = 'Foo';
        $actual = $this->Feature->getName();

        $this->Feature->setDescription('Bar');
        $expected = 'Bar';
        $actual = $this->Feature->getDescription();

        $this->assertEmpty($this->Feature->getStrategies());
    }

    /**
     * @covers ::pushStrategy
     */
    public function testInheritedPushStrategy()
    {
        $this->assertEmpty($this->Feature->getStrategies());

        $Auth = $this->getMock(
            '\FeatureToggle\Strategy\TestStrategy',
            array('__invoke')
        );
        $callback = function ($Feature) use ($Auth) {
            return $Auth->get('feature.foo');
        };

        $this->Feature->pushStrategy($callback);

        $this->assertNotEmpty($this->Feature->getStrategies());

        $this->Feature->pushStrategy(new TestStrategy());
        $this->assertEquals(count($this->Feature->getStrategies()), 2);
    }

    /**
     * @covers ::pushStrategy
     * @expectedException \InvalidArgumentException
     */
    public function testInheritedPushStrategyThrowsException()
    {
        $this->Feature->pushStrategy('bar');
    }

    /**
     * @covers ::disable
     */
    public function testDisable()
    {
        $this->Feature->enable();
        $this->Feature->disable();
        $this->assertFalse($this->Feature->isEnabled());
    }

    /**
     * @covers ::enable
     */
    public function testEnable()
    {
        $this->Feature->disable();
        $this->Feature->enable();
        $this->assertTrue($this->Feature->isEnabled());
    }

    /**
     * @covers ::isEnabled
     */
    public function testIsEnabledWithTwoStrategiesPassing()
    {
        $this->assertFalse($this->Feature->isEnabled());

        $this->Feature->enable();
        $this->assertTrue($this->Feature->isEnabled());


        $strategy1 = $this->getMock(
            '\FeatureToggle\Strategy\TestStrategy',
            array('__invoke')
        );
        $strategy1->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue(true));

        $strategy2 = $this->getMock(
            '\FeatureToggle\Strategy\TestStrategy',
            array('__invoke')
        );
        $strategy2->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue(true));

        $this->Feature->pushStrategy($strategy1);
        $this->Feature->pushStrategy($strategy2);
        $this->assertTrue($this->Feature->isEnabled());
    }

    /**
     * @covers ::isEnabled
     */
    public function testIsEnabledWithOneStrategyPassingAndOneStrategyFailing()
    {

        $strategy1 = $this->getMock(
            '\FeatureToggle\Strategy\TestStrategy',
            array('__invoke')
        );
        $strategy1->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue(true));

        $strategy2 = $this->getMock(
            '\FeatureToggle\Strategy\TestStrategy',
            array('__invoke')
        );
        $strategy2->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue(false));

        $this->Feature->pushStrategy($strategy1);
        $this->Feature->pushStrategy($strategy2);
        $this->assertFalse($this->Feature->isEnabled());
    }
}
