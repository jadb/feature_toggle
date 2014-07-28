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
 * Feature manager.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 */
class FeatureManager
{
    /**
     * Tells if a feature is enabled.
     *
     * @param string $feature Feature's name.
     * @return boolean
     */
    public static function isEnabled($feature, array $args = [])
    {
        return FeatureRegistry::get($feature)->isEnabled($args);
    }
}
