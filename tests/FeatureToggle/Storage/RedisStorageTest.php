<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Test\Storage;

use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\Feature\EnabledFeature;
use FeatureToggle\Storage\RedisStorage;

/**
 * Redis storage test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Storage\RedisStorage
 */
class RedisStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Predis\Client
     */
    protected $redis;

    /**
     * @var \FeatureToggle\Storage\RedisStorage
     */
    protected $storage;

    public function setUp()
    {
        $this->redis = $this->getMock('Predis\Client', ['hset', 'hget', 'hgetall', 'del']);
        $this->storage = new RedisStorage($this->redis, 'bar');
    }

    public function tearDown()
    {
        unset($this->path, $this->redis);
    }

    public function testAdd()
    {
        $feature = new BooleanFeature();

        $this->redis->expects($this->once())
            ->method('hset')
            ->with('bar', 'foo', serialize($feature));

        $result = $this->storage->add('foo', $feature);
        $this->assertInstanceOf('FeatureToggle\Storage\RedisStorage', $result);
    }

    public function testGet()
    {
        $expected = new BooleanFeature();

        $this->redis->expects($this->once())
            ->method('hget')
            ->with('bar', 'foo')
            ->will($this->returnValue(serialize($expected)));

        $result = $this->storage->get('foo');
        $this->assertEquals($expected, $result);
    }

    public function testIndex()
    {
        $boolean = new BooleanFeature();
        $enabled = new EnabledFeature();
        $expected = compact('boolean', 'enabled');

        $this->redis->expects($this->once())
            ->method('hgetall')
            ->with('bar')
            ->will($this->returnValue(array_map('serialize', $expected)));

        $result = $this->storage->index();
        $this->assertEquals($expected, $result);
    }

    public function testRemove()
    {
        $this->redis->expects($this->once())
            ->method('del')
            ->with('bar', 'enabled');

        $this->assertInstanceOf('FeatureToggle\Storage\RedisStorage', $this->storage->remove('enabled'));
    }

    public function testFlush()
    {
        $this->redis->expects($this->once())
            ->method('del')
            ->with('bar');

        $this->assertInstanceOf('FeatureToggle\Storage\RedisStorage', $this->storage->flush());
    }
}
