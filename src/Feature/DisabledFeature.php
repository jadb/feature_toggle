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
 * Disabled feature.
 *
 * Forces feature to always be disabled.
 */
class DisabledFeature extends BooleanFeature
{
    /**
     * {@inheritdoc}
     */
    public function isEnabled(array $args = []): bool
    {
        return false;
    }
}
