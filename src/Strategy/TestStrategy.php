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

/**
 * Test strategy.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Strategy
 * @author Jad Bitar <jadbitar@mac.com>
 */
class TestStrategy extends AbstractStrategy
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(FeatureInterface $Feature, array $args = []): bool
    {
        return;
    }
}
