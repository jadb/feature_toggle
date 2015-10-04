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
use Memcached;

/**
 * Memcached storage (requires the memcached extension).
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Storage
 * @author Jad Bitar <jadbitar@mac.com>
 */
class MemcachedStorage extends AbstractStorage
{
    /**
     * Memcached instance.
     *
     * @var \Memcached
     */
    protected $memcached;

    /**
     * Memcached key's prefix.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Constructor.
     *
     * @param \Memcached $memcached
     * @param string $prefix String used to prefix aliases.
     */
    public function __construct(Memcached $memcached, $prefix = 'ft_')
    {
        $this->memcached = $memcached;
        $this->prefix = $prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function add($alias, FeatureInterface $feature)
    {
        $key = $this->key($alias);
        $this->memcached->set($key, $this->feature($feature));

        if (!$this->memcached->append($this->prefix, "|$key")) {
            $this->memcached->set($this->prefix, $key);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        return unserialize($this->memcached->get($this->key($alias)));
    }

    /**
     * {@inheritdoc}
     */
    public function index()
    {
        $features = [];

        if (!$keys = $this->memcached->get($this->prefix)) {
            return $features;
        }

        foreach (explode('|', $keys) as $key) {
            if ($feature = $this->memcached->get($key)) {
                array_push($features, unserialize($feature));
            }
        }

        return $features;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($alias)
    {
        $this->memcached->delete($this->key($alias));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        if ($keys = $this->memcached->get($this->prefix)) {
            $this->memcached->delete($this->prefix);
            $this->memcached->deleteMulti(explode('|', $keys));
        }

        return $this;
    }

    /**
     * @param  string $alias
     * @return string
     */
    protected function key($alias)
    {
        return md5($this->prefix . $alias);
    }
}
