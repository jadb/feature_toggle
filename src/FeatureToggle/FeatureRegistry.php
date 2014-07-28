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
        if (self::check($name)) {
            throw new \InvalidArgumentException('Duplicate feature identifier.');
        }

        self::$features[$name] = $Feature;
    }

    /**
     * Checks if a feature with given name exists.
     *
     * @param string $name Feature's name.
     * @return boolean
     */
    public static function check($name)
    {
        return array_key_exists($name, self::$features);
    }

    /**
     * Resets registry.
     *
     * @return void
     */
    public static function flush()
    {
        self::$features = array();
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
        if (!self::check($name)) {
            throw new \InvalidArgumentException('Unknown feature identifier.');
        }

        return self::$features[$name];
    }

    /**
     * Initializes feature and adds it to registry.
     *
     * @param [type] $name [description]
     * @param array $config [description]
     * @return [type]
     */
    public static function init($name, $config = array())
    {
        $FeatureBuilder = new FeatureBuilder();
        self::add($name, $FeatureBuilder->createFeature($name, $config));
        return self::get($name);
    }
}