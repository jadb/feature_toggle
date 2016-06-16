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
 */
abstract class AbstractFeature implements FeatureInterface
{
    /**
     * Feature's description.
     *
     * @var string
     */
    private $description;

    /**
     * Feature's name.
     *
     * @var string
     */
    private $name;

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
     * @param string|null $description Feature's description.
     */
    public function __construct(string $name, string $description = null)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    final public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    final public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns defined strategies' stack.
     *
     * @return array
     */
    final public function getStrategies(): array
    {
        return $this->strategies;
    }

    /**
     * {@inheritdoc}
     */
    final public function pushStrategy(callable $strategy): FeatureInterface
    {
        $feature = clone($this);
        array_push($feature->strategies, $strategy);
        return $feature;
    }

    /**
     * {@inheritdoc}
     */
    final public function setDescription(string $description): FeatureInterface
    {
        $feature = clone($this);
        $feature->description = $description;
        return $feature;
    }

    /**
     * {@inheritdoc}
     */
    final public function setName(string $name): FeatureInterface
    {
        $feature = clone($this);
        $feature->name = $name;
        return $feature;
    }
}
