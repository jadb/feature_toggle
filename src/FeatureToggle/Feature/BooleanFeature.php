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
 * @author Jad Bitar <jadbitar@mac.com>
 */
class BooleanFeature extends AbstractFeature
{
    /**
     * Default feature's state.
     *
     * @var boolean
     */
    protected $isEnabled = false;

    /**
     * Sets feature's default state to disabled.
     *
     * @return void
     */
    public function disable()
    {
        $this->isEnabled = false;
    }

    /**
     * Sets feature's default state to enabled.
     *
     * @return void
     */
    public function enable()
    {
        $this->isEnabled = true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        $strategies = $this->getStrategies();
        if (empty($strategies)) {
            return $this->isEnabled;
        }

        $isEnabled = false;

        foreach ($strategies as $strategy) {
            if (call_user_func($strategy, $this)) {
                $isEnabled = true;
                break;
            }
        }

        return $isEnabled;
    }
}
