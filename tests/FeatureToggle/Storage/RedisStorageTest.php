<?php declare(strict_types=1);

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
use Predis\Client;

class RedisStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Predis\Client
     */
    private $redis;

    /**
     * @var \FeatureToggle\Storage\RedisStorage
     */
    private $storage;

    public function setUp()
    {
        $this->redis = $this->getMockBuilder(Client::class)
            ->setMethods(['hset', 'hget', 'hgetall', 'hdel', 'del'])
            ->getMock();

        $this->storage = new RedisStorage($this->redis, 'customPrefix');
    }

    public function tearDown()
    {
        unset($this->redis, $this->storage);
    }

    public function testAdd()
    {
        $feature = new BooleanFeature('foo');

        $this->redis->expects($this->once())
            ->method('hset')
            ->with('customPrefix', 'testAlias', serialize($feature));

        $result = $this->storage->add('testAlias', $feature);
        $this->assertInstanceOf('FeatureToggle\Storage\RedisStorage', $result);
    }

    public function testGet()
    {
        $expected = new BooleanFeature('foo');

        $this->redis->expects($this->once())
            ->method('hget')
            ->with('customPrefix', 'testAlias')
            ->will($this->returnValue(serialize($expected)));

        $result = $this->storage->get('testAlias');
        $this->assertEquals($expected, $result);
    }

    public function testIndex()
    {
        $boolean = new BooleanFeature('foo');
        $enabled = new EnabledFeature('bar');
        $expected = compact('boolean', 'enabled');

        $this->redis->expects($this->once())
            ->method('hgetall')
            ->with('customPrefix')
            ->will($this->returnValue(array_map('serialize', $expected)));

        $result = $this->storage->index();
        $this->assertEquals($expected, $result);
    }

    public function testRemove()
    {
        $this->redis->expects($this->once())
            ->method('hdel')
            ->with('customPrefix', ['testAlias']);

        $this->assertInstanceOf(RedisStorage::class, $this->storage->remove('testAlias'));
    }

    public function testFlush()
    {
        $this->redis->expects($this->once())
            ->method('del')
            ->with(['customPrefix']);

        $this->assertInstanceOf(RedisStorage::class, $this->storage->flush());
    }
}
