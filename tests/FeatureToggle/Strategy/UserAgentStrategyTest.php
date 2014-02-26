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
use FeatureToggle\Strategy\UserAgentStrategy;

/**
 * Boolean feature test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Strategy\UserAgentStrategy
 */
class UserAgentStrategyTest extends \PHPUnit_Framework_TestCase
{
    private $resetVar;
    private $Strategy;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->Strategy = new UserAgentStrategy(array('/foo$/', '/^bar/'));
        $this->resetVar = $_SERVER;
        $_SERVER = array();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $_SERVER = $this->resetVar;
        unset($this->resetVar, $this->Strategy);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $this->assertObjectHasAttribute('patterns', $this->Strategy);
    }

    /**
     * @covers ::getUserAgent
     */
    public function testGetUserAgent()
    {
        $result = $this->Strategy->getUserAgent();
        $expected = '';
        $this->assertEquals($expected, $result);

        $_SERVER['HTTP_USER_AGENT'] = 'foo';
        $result = $this->Strategy->getUserAgent();
        $expected = 'foo';
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ::__invoke
     */
    public function testInvoke()
    {
        $this->assertFalse(call_user_func($this->Strategy, new TestFeature('foo')));

        $_SERVER['HTTP_USER_AGENT'] = 'foo';
        $this->assertTrue(call_user_func($this->Strategy, new TestFeature('foo')));
    }
}
