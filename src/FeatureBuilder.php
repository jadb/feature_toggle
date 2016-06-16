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

/**
 * Feature builder.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 */
class FeatureBuilder
{

    /**
     * @param string $name
     * @param array $config
     * @return \FeatureToggle\Feature\FeatureInterface
     */
    public static function buildFeature(string $name, array $config = []): FeatureInterface
    {
        $defaultConfig = [
            'description' => null,
            'type' => 'boolean',
            'namespace' => __NAMESPACE__ . '\Feature\\',
            'strategies' => [],
        ];

        list($description, $type, $namespace, $strategies)
            = array_values(array_merge($defaultConfig, $config));

        $classname = $namespace . ucfirst($type) . 'Feature';

        /** @var \FeatureToggle\Feature\FeatureInterface $feature */
        $feature = new $classname($name, $description);

        foreach ((array)$strategies as $class => $args) {
            $feature->pushStrategy(is_numeric($class)
                ? $args
                : new $class(...$args)
            );
        }

        return $feature;
    }
}
