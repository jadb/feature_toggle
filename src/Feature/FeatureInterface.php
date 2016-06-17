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

use Serializable;

/**
 * Feature interface.
 */
interface FeatureInterface extends Serializable
{
    /**
     * Returns the feature's description.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Returns the feature's name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Tells if feature is enabled.
     *
     * @param array $args
     * @return bool
     */
    public function isEnabled(array $args = []): bool;

    /**
     * Sets new description to a clone of the feature and returns that instance.
     *
     * @param string $description Feature's description.
     * @return \FeatureToggle\Feature\FeatureInterface
     */
    public function setDescription(string $description): FeatureInterface;

    /**
     * Sets new name to a clone of the feature and returns that instance.
     *
     * @param string $name Feature's name.
     * @return \FeatureToggle\Feature\FeatureInterface
     */
    public function setName(string $name): FeatureInterface;

    /**
     * Pushes new strategy to clone of the feature and returns that instance.
     *
     * @param \FeatureToggle\Strategy\StrategyInterface|callable $strategy
     * @return \FeatureToggle\Feature\FeatureInterface
     */
    public function pushStrategy(callable $strategy): FeatureInterface;

    /**
     * Returns list of defined strategies for this feature's instance.
     *
     * @return array
     */
    public function getStrategies(): array;
}
