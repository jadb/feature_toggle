<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Strategy;

/**
 * Strategy interface.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Strategy
 * @author Jad Bitar <jadbitar@mac.com>
 */
interface StrategyInterface
{
    /**
     * Tells if strategy passes or not.
     *
     * @param FeatureInterface $Feature
     * @return boolean
     */
    public function __invoke($Feature);

    /**
     * Returns strategy's name.
     *
     * @return string
     */
    public function getName();
}
