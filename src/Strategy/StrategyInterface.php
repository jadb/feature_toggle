<?php declare(strict_types=1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Strategy;

use FeatureToggle\Feature\FeatureInterface;
use Serializable;

/**
 * Strategy interface.
 */
interface StrategyInterface extends Serializable
{
    /**
     * Tells if strategy passes or not.
     *
     * @param \FeatureToggle\Feature\FeatureInterface $Feature
     * @param array $args
     * @return boolean
     */
    public function __invoke(FeatureInterface $Feature, array $args = []): bool;

    /**
     * Returns strategy's name.
     *
     * @return string
     */
    public function getName(): string;
}
