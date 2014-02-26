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

use FeatureToggle\Feature\DisabledFeature;

/**
 * Disabled feature test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Feature\DisabledFeature
 */
class DisabledFeatureTest extends \PHPUnit_Framework_TestCase
{
    const FEATURE_NAME = 'Disabled Feature Test';
    const FEATURE_DESC = 'Testing the disabled feature class';

    /**
     * @covers ::isEnabled
     */
    public function testIsEnabled()
    {
        $Feature = new DisabledFeature(self::FEATURE_NAME, self::FEATURE_DESC);
        $this->assertFalse($Feature->isEnabled());
    }
}
