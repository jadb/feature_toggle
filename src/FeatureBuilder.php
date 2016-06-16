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
    public function createFeature($name, $config = array())
    {
        $defaultConfig = array(
            'description' => null,
            'type' => 'boolean',
            'namespace' => __NAMESPACE__ . '\Feature\\',
            'strategies' => array(),
        );

        extract(array_merge($defaultConfig, $config));

        $classname = $namespace . ucfirst($type) . 'Feature';

        $this->setFeature(new $classname($name, $description));
        $this->addStrategies((array) $strategies);
        return $this->Feature;
    }

    public function setFeature($Feature)
    {
        $this->Feature = $Feature;
    }

    /**
     * Adds callback to feature object's strategies.
     *
     * @param function $callback Anonymous function to use as strategy.
     * @return void
     */
    public function addCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException();
        }

        $this->Feature->pushStrategy($callback);
    }

    /**
     * Adds strategies to feature object.
     *
     * @param array $strategies Strategies.
     * @return void
     */
    public function addStrategies($strategies)
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
     * @throws \InvalidArgumentException If feature object does not support strategies.
     * @throws \InvalidArgumentException If $class is not a string.
     * @throws \InvalidArgumentException If $class is not a valid class name.
     */
    public function addStrategy($class, $args)
    {
        if (!method_exists($this->Feature, 'pushStrategy')) {
            throw new \InvalidArgumentException();
        }

        if (!is_string($class)) {
            throw new \InvalidArgumentException();
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
