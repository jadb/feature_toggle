<?php declare(strict_types=1);

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
    private $strategies = [];

    /**
     * Constructor.
     *
     * @param string $name Feature's name.
     * @param string $description Feature's description.
     */
    public function __construct(string $name = null, string $description = null)
    {
        $this->setName($name);
        $this->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns defined strategies' stack.
     *
     * @return array
     */
    public function getStrategies(): array
    {
        return $this->strategies;
    }

    /**
     * Adds strategy to defined strategies' stack.
     *
     * @param callable $callback Any callable.
     * @return void
     */
    public function pushStrategy(callable $callback)
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
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
