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
 * Threshold feature.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Feature
 * @author Jad Bitar <bitarjad@gmail.com>
 */
class ThresholdFeature extends BooleanFeature
{
    /**
     * Getter/setter for the `BooleanFeature::$threshold` property.
     *
     * @param int $val The minimum threshold for a feature to be considered enabled.
     * @return int The minimum threshold for a feature to be considered enabled.
     */
    public function threshold($val = null)
    {
        if ($val !== null) {
            if (!is_int($val)) {
                throw new InvalidArgumentException('Only integer allowed.');
            }
            $this->threshold = $val;
        }
        return $this->threshold;
    }
}
