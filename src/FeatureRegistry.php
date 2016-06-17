<?php declare(strict_types=1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle;

use FeatureToggle\Exception\UnknownFeatureException;
use FeatureToggle\Feature\FeatureInterface;
use FeatureToggle\Storage\HashStorage;
use FeatureToggle\Storage\StorageInterface;

/**
 * Feature registry.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 */
class FeatureRegistry
{
    private static $storage;

    public static function setStorage(StorageInterface $storage)
    {
        static::$storage = $storage;
    }

    private static function getStorage(): StorageInterface
    {
        return static::$storage = static::$storage ?: new HashStorage();
    }

    /**
     * Adds feature to registry.
     *
     * @param string $name Feature's name.
     * @param \FeatureToggle\Feature\FeatureInterface $feature Feature object to add.
     * @throws \InvalidArgumentException If feature's name already exists in registry.
     */
    public static function add(string $name, FeatureInterface $feature)
    {
        static::getStorage()->add($name, clone($feature));
    }

    /**
     * Checks if a feature with given name exists.
     *
     * @param string $name Feature's name.
     * @return boolean
     */
    public static function check(string $name): bool
    {
        try {
            static::getStorage()->get($name);
            return true;
        } catch (UnknownFeatureException $e) {
            return false;
        }
    }

    /**
     * Resets registry.
     *
     * @return void
     */
    public static function flush()
    {
        static::getStorage()->flush();
    }

    /**
     * Returns feature from registry.
     *
     * @param string $name Feature's name.
     * @return \FeatureToggle\Feature\FeatureInterface Feature object.
     * @throws \FeatureToggle\Exception\UnknownFeatureException If feature's name does
     *   not exist in registry.
     */
    public static function get(string $name): FeatureInterface
    {
        return clone(static::getStorage()->get($name));
    }

    /**
     * Initializes feature and adds it to registry.
     *
     * @param string $name Feature's name.
     * @param array $config Feature configuration.
     * @return \FeatureToggle\Feature\FeatureInterface Feature object.
     * @throws \FeatureToggle\Exception\UnknownFeatureException If feature's name does
     *   not exist in registry.
     */
    public static function init(string $name, array $config = []): FeatureInterface
    {
        $feature = FeatureFactory::buildFeature($name, $config);
        static::add($name, $feature);
        return $feature;
    }
}
