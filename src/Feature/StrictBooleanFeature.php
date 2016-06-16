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
 * Boolean feature.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Feature
 * @author Jad Bitar <bitarjad@gmail.com>
 * @author Raúl Santos <borfast@gmail.com>
 */
class StrictBooleanFeature extends BooleanFeature
{
    /**
     * {@inheritdoc}
     */
    protected $strict = true;

    /**
     * {@inheritdoc}
     */
    public function isEnabled(array $args = []): bool
    {
        $strategies = $this->getStrategies();
        $this->threshold = count($strategies);
        return $this->check($args);
    }
}
