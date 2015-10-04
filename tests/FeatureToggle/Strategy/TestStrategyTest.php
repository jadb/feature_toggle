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
use FeatureToggle\Strategy\TestStrategy;

/**
 * Test strategy test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Strategy\TestStrategy
 */
class TestStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__invoke
     */
    public function testInvoke()
    {
        $this->assertNull(call_user_func(new TestStrategy(), new TestFeature('foo')));
    }

    /**
     * @covers ::getName
     * @covers ::setName
     */
    public function testInheritedMethods()
    {
        $Strategy = new TestStrategy();

        $expected = 'Test';
        $actual = $Strategy->getName();
        $this->assertEquals($expected, $actual);

        $Strategy->setName('New Name');
        $expected = 'New Name';
        $actual = $Strategy->getName();
        $this->assertEquals($expected, $actual);
    }
}
