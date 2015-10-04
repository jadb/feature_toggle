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

/**
 * Feature registry.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 */
class FeatureRegistry
{
    /**
     * Features registry.
     *
     * @var array
     */
    protected static $features = array();

    /**
     * Adds feature to registry.
     *
     * @param string $name Feature's name.
     * @param Feature\FeatureInterface $Feature Feature object to add.
     * @throws \InvalidArgumentException If feature's name already exists in registry.
     */
    public static function add($name, Feature\FeatureInterface $Feature)
    {
        if (static::check($name)) {
            throw new \InvalidArgumentException('Duplicate feature identifier.');
        }

        static::$features[$name] = $Feature;
    }

    /**
     * Checks if a feature with given name exists.
     *
     * @param string $name Feature's name.
     * @return boolean
     */
    public static function check($name)
    {
        return array_key_exists($name, static::$features);
    }

    /**
     * Resets registry.
     *
     * @return void
     */
    public static function flush()
    {
        static::$features = array();
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
        if (!static::check($name)) {
            throw new \InvalidArgumentException('Unknown feature identifier.');
        }

        return static::$features[$name];
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
        static::add($name, $FeatureBuilder->createFeature($name, $config));
        return static::get($name);
    }
}
