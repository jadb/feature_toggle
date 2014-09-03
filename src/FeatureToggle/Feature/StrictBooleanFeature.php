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
 * Boolean feature.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Feature
 * @author Raúl Santos <borfast@gmail.com>
 */
class StrictBooleanFeature extends BooleanFeature
{
    /**
     * {@inheritdoc}
     */
    public function isEnabled(array $args = [])
    {
        $strategies = $this->getStrategies();
        if (empty($strategies)) {
            return $this->isEnabled;
        }

        $isEnabled = true;

        foreach ($strategies as $strategy) {
            if (!call_user_func($strategy, $this, $args)) {
                $isEnabled = false;
                break;
            }
        }

        return $isEnabled;
    }
}
