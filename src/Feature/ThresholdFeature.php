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

use InvalidArgumentException;

/**
 * Threshold feature.
 *
 * Considered enabled only if a minimum number of strategies pass.
 */
class ThresholdFeature extends BooleanFeature
{
    /**
     * Getter/setter for the `BooleanFeature::$threshold` property.
     *
     * @param int $val The minimum threshold for a feature to be considered enabled.
     * @return int The minimum threshold for a feature to be considered enabled.
     */
    public function threshold(int $val = null): int
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
