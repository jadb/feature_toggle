<?php declare(strict_types=1);

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
 */
class MemcachedStorage extends AbstractStorage
{
    /**
     * Memcached instance.
     *
     * @var \Memcached
     */
    private $memcached;

    /**
     * Memcached key's prefix.
     *
     * @var string
     */
    private $prefix;

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
    public function add(string $alias, FeatureInterface $feature): StorageInterface
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
    public function get(string $alias): FeatureInterface
    {
        return unserialize($this->memcached->get($this->key($alias)));
    }

    /**
     * {@inheritdoc}
     */
    public function index(): array
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
    public function remove(string $alias): StorageInterface
    {
        $this->memcached->delete($this->key($alias));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(): StorageInterface
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
    protected function key($alias): string
    {
        return md5($this->prefix . $alias);
    }
}
