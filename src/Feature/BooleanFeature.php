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
 * Considered enabled if one ore more strategies pass.
 */
class BooleanFeature extends AbstractFeature
{
    /**
     * Default feature's state.
     *
     * @var boolean
     */
    private $isEnabled = false;

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
     * @return \FeatureToggle\Feature\BooleanFeature
     */
    final public function disable(): BooleanFeature
    {
        return $this->setState(false);
    }

    /**
     * Sets feature's default state to enabled.
     *
     * @return \FeatureToggle\Feature\BooleanFeature
     */
    final public function enable(): BooleanFeature
    {
        return $this->setState(true);
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(array $args = []): bool
    {
        return $this->check($args);
    }

    /**
     * Tells if feature is enabled.
     *
     * @param array $args
     * @return bool
     */
    protected function check(array $args = []): bool
    {
        $isEnabled = (int)$this->isEnabled;
        $strategies = $this->getStrategies();
        if (empty($strategies)) {
            return (bool)$isEnabled;
        }

        foreach ($strategies as $strategy) {
            if ((bool)call_user_func($strategy, $this, $args)) {
                $isEnabled++;
            }
        }

        return $isEnabled > $this->threshold
            || ($this->strict && $isEnabled === $this->threshold);
    }

    /**
     * @param bool $enabled
     * @return \FeatureToggle\Feature\BooleanFeature
     */
    private function setState(bool $enabled): BooleanFeature
    {
        $feature = clone($this);
        $feature->isEnabled = $enabled;
        return $feature;
    }
}
