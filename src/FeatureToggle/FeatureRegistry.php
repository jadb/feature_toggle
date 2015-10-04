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

   /**
     * Storage.
     *
     * @var \FeatureToggle\Storage\StorageInterface
     */
    protected static $storage;

    /**
     * Storage setter.
     *
     * @param \FeatureToggle\Storage\StorageInterface $storage Storage.
     */
    public static function setStorage(StorageInterface $storage)
    {
        static::$storage = $storage;
    }

    /**
     * Storage getter.
     *
     * @return \FeatureToggle\Storage\HashStorage|\FeatureToggle\Storage\StorageInterface
     */
    protected static function getStorage()
    {
        if (!$storage = static::$storage) {
            $storage = new HashStorage();
            static::setStorage($storage);
        }

        return $storage;
    }

    /**
     * Adds feature to registry.
     *
     * @param string $name Feature's name.
     * @param Feature\FeatureInterface $Feature Feature object to add.
     * @throws \InvalidArgumentException If feature's name already exists in registry.
     */
    public static function add($name, Feature\FeatureInterface $Feature)
    {
        static::getStorage()->add($name, $Feature);
    }

    /**
     * Checks if a feature with given name exists.
     *
     * @param string $name Feature's name.
     * @return boolean
     */
    public static function check($name)
    {
        try {
            static::getStorage()->get($name);
            return true;
        } catch (\InvalidArgumentException $e) {
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
     * @return Feature\FeatureInterface Feature object.
     * @throws \InvalidArgumentException If feature's name does not exist in registry.
     */
    public static function get($name)
    {
        return static::getStorage()->get($name);
    }

    /**
     * Initializes feature and adds it to registry.
     *
     * @param string $name Feature's name.
     * @param array $config Feature configuration.
     * @return Feature\FeatureInterface Feature object.
     */
    public static function init($name, $config = array())
    {
        $FeatureBuilder = new FeatureBuilder();
        $feature = $FeatureBuilder->createFeature($name, $config);
        static::getStorage()->add($name, $feature);
        return $feature;
    }
}
