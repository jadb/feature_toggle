<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Feature;

/**
 * Abstract feature.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Feature
 * @author Jad Bitar <jadbitar@mac.com>
 */
abstract class AbstractFeature implements FeatureInterface
{
    /**
     * Feature's description.
     *
     * @var string
     */
    protected $description;

    /**
     * Feature's name.
     *
     * @var string
     */
    protected $name;

    /**
     * Strategies' stack.
     *
     * @var array
     */
    private $strategies = array();

    /**
     * Constructor.
     *
     * @param string $name Feature's name.
     * @param string $description Feature's description.
     */
    public function __construct($name = null, $description = null)
    {
        $this->setName($name);
        $this->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns defined strategies' stack.
     *
     * @return array
     */
    public function getStrategies()
    {
        return $this->strategies;
    }

    /**
     * Adds strategy to defined strategies' stack.
     *
     * @param mixed $callback Closure or object with an `__invoke` method.
     * @return void
     */
    public function pushStrategy($callback)
    {
        if (!is_callable($callback)) {
            throw new  \InvalidArgumentException(
                'Strategy must be callable (callback or object with an __invoke method), '
                . var_export($callback, true)
                . ' given.'
            );
        }

        array_push($this->strategies, $callback);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
