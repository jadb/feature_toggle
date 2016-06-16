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
     * Current feature build.
     *
     * @var Feature\FeatureInterface
     */
    protected $Feature;

    /**
     * Creates feature object.
     *
     * @param string $name Feature's name
     * @param array $config Feature's configuration.
     * @return Feature\FeatureInterface Created feature object.
     */
    public function createFeature(string $name, array $config = []): FeatureInterface
    {
        $defaultConfig = [
            'description' => null,
            'type' => 'boolean',
            'namespace' => __NAMESPACE__ . '\Feature\\',
            'strategies' => [],
        ];

        extract(array_merge($defaultConfig, $config));

        $classname = $namespace . ucfirst($type) . 'Feature';

        $this->setFeature(new $classname($name, $description));
        $this->addStrategies((array) $strategies);
        return $this->Feature;
    }

    public function setFeature(FeatureInterface $Feature)
    {
        $this->Feature = $Feature;
    }

    /**
     * Adds callback to feature object's strategies.
     *
     * @param callable|\FeatureToggle\Strategy\StrategyInterface $callback Any callable. Should
     *   return a boolean (casted to boolean anyways).
     * @return void
     */
    public function addCallback(callable $callback)
    {
        $this->Feature->pushStrategy($callback);
    }

    /**
     * Adds strategies to feature object.
     *
     * @param \FeatureToggle\Strategy\StrategyInterface[] $strategies Strategies.
     * @return void
     */
    public function addStrategies(array $strategies)
    {
        foreach ($strategies as $class => $args) {
            if (is_numeric($class)) {
                $this->addCallback($args);
                continue;
            }

            $this->addStrategy($class, $args);
        }
    }

    /**
     * Adds strategy to feature object.
     *
     * @param string $class Strategy class name.
     * @param array $args Strategy class constructors arguments.
     * @return void
     * @throws \InvalidArgumentException If feature object does not support strategies or
     *   if class doesn't exist.
     */
    public function addStrategy(string $class, array $args)
    {
        if (!method_exists($this->Feature, 'pushStrategy')) {
            throw new \InvalidArgumentException('Feature does not support strategies.');
        }

        if (!class_exists($class)) {
            $class = __NAMESPACE__ . '\Strategy\\' . ucfirst($class) . 'Strategy';
            if (!class_exists($class)) {
                throw new \InvalidArgumentException();
            }
        }

        switch (count($args)) {
            case 5:
                $Strategy = new $class($args[0], $args[1], $args[2], $args[3], $args[4]);
                break;
            case 4:
                $Strategy = new $class($args[0], $args[1], $args[2], $args[3]);
                break;
            case 3:
                $Strategy = new $class($args[0], $args[1], $args[2]);
                break;
            case 2:
                $Strategy = new $class($args[0], $args[1]);
                break;
            case 1:
                $Strategy = new $class($args[0]);
                break;
            default:
                $Strategy = new $class();
        }

        $this->Feature->pushStrategy($Strategy);
    }
}
