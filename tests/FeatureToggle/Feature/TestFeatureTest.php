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

use FeatureToggle\Feature\TestFeature;

/**
 * Test feature test class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\Feature\TestFeature
 */
class TestFeatureTest extends \PHPUnit_Framework_TestCase
{
    const FEATURE_NAME = 'Test Feature Test';
    const FEATURE_DESC = 'Testing the test feature class';

    /**
     * @covers ::isEnabled
     */
    public function testIsEnabled()
    {
        $Feature = new TestFeature(self::FEATURE_NAME, self::FEATURE_DESC);
        $this->assertFalse($Feature->isEnabled());
    }
}
