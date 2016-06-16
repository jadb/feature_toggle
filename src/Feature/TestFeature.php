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
 * Test feature.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Feature
 * @author Jad Bitar <jadbitar@mac.com>
 */
class TestFeature extends AbstractFeature
{
    /**
     * Easier dependency injection.
     *
     * @var boolean
     */
    public $isEnabled = false;

    /**
     * {@inheritdoc}
     */
    public function isEnabled(array $args = [])
    {
        return $this->isEnabled;
    }
}
