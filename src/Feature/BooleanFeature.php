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
     * Mode.
     *
     * @var boolean
     */
    protected $strict = false;

    /**
     * Minimum number of strategies to pass for a feature to be considered enabled.
     *
     * @var integer
     */
    protected $threshold = 1;

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
    public function isEnabled(array $args = [])
    {
        return $this->check($args);
    }

    /**
     * Tells if feature is enabled.
     *
     * @return bool
     */
    protected function check(array $args)
    {
        $isEnabled = (int)$this->isEnabled;
        $strategies = $this->getStrategies();
        if (empty($strategies)) {
            return (bool)$isEnabled;
        }

        foreach ($strategies as $strategy) {
            if (call_user_func($strategy, $this, $args)) {
                $isEnabled++;
            }
        }

        return $isEnabled > $this->threshold || (!$this->strict && ($isEnabled === $this->threshold));
    }
}
