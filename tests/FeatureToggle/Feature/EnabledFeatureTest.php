<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Test\Feature;

use FeatureToggle\Feature\EnabledFeature;

/**
 * Enabled feature test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Feature\EnabledFeature
 */
class EnabledFeatureTest extends \PHPUnit_Framework_TestCase
{
    const FEATURE_NAME = 'Enabled Feature Test';
    const FEATURE_DESC = 'Testing the enabled feature class';

    /**
     * @covers ::isEnabled
     */
    public function testIsEnabled()
    {
        $Feature = new EnabledFeature(self::FEATURE_NAME, self::FEATURE_DESC);
        $this->assertTrue($Feature->isEnabled());
    }
}
