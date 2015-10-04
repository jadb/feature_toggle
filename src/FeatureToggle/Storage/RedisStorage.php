<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Storage;

use FeatureToggle\Feature\FeatureInterface;
use Predis\Client;

/**
 * Redis storage (requires `predis/predis` package).
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Storage
 * @author Jad Bitar <jadbitar@mac.com>
 */
class RedisStorage extends AbstractStorage
{
    /**
     * Redis client instance.
     *
     * @var \Predis\Client
     */
    protected $redis;

    protected $prefix;

    /**
     * Constructor.
     *
     * @param \Predis\Client $redis Redis client.
     */
    public function __construct(Client $redis, $prefix = 'ft_')
    {
        $this->redis = $redis;
        $this->prefix = $prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function add($alias, FeatureInterface $feature)
    {
        $this->redis->hset($this->prefix, $alias, $this->feature($feature));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        return unserialize($this->redis->hget($this->prefix, $alias));
    }

    /**
     * {@inheritdoc}
     */
    public function index()
    {
        $features = [];

        foreach ($this->redis->hgetall($this->prefix) as $alias => $feature) {
            $features[$alias] = unserialize($feature);
        }

        return $features;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($alias)
    {
        $this->redis->del($this->prefix, $alias);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->redis->del($this->prefix);
        return $this;
    }
}
