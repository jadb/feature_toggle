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
 * Feature interface.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Feature
 * @author Jad Bitar <jadbitar@mac.com>
 */
interface FeatureInterface
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
     * Sets the feature's descriptions.
     *
     * @param string $description Feature's description.
     * @return void
     */
    public function setDescription(string $description);

    /**
     * Sets the feature's name.
     *
     * @param string $name Feature's name.
     * @return void
     */
    public function setName(string $name);

    /**
     * @param callable $strategy
     * @return void
     */
    public function pushStrategy(callable $strategy);
}
