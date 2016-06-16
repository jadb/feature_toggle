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

use FeatureToggle\Feature\FeatureInterface;
use InvalidArgumentException;

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
    protected static $features = [];

    /**
     * Adds feature to registry.
     *
     * @param string $name Feature's name.
     * @param \FeatureToggle\Feature\FeatureInterface $Feature Feature object to add.
     * @throws \InvalidArgumentException If feature's name already exists in registry.
     */
    public static function add(string $name, FeatureInterface $Feature)
    {
        if (static::check($name)) {
            throw new InvalidArgumentException('Duplicate feature identifier.');
        }

        static::$features[$name] = clone($Feature);
    }

    /**
     * Checks if a feature with given name exists.
     *
     * @param string $name Feature's name.
     * @return boolean
     */
    public static function check($name): bool
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
        static::$features = [];
    }

    /**
     * Returns feature from registry.
     *
     * @param string $name Feature's name.
     * @return \FeatureToggle\Feature\FeatureInterface Feature object.
     * @throws \InvalidArgumentException If feature's name does not exist in registry.
     */
    public static function get(string $name): FeatureInterface
    {
        if (!static::check($name)) {
            throw new InvalidArgumentException('Unknown feature identifier.');
        }

        return clone(static::$features[$name]);
    }

    /**
     * Initializes feature and adds it to registry.
     *
     * @param string $name Feature's name.
     * @param array $config Feature configuration.
     * @return \FeatureToggle\Feature\FeatureInterface Feature object.
     */
    public static function init(string $name, array $config = []): FeatureInterface
    {
        $feature = FeatureFactory::buildFeature($name, $config);
        static::add($name, $feature);
        return $feature;
    }
}
