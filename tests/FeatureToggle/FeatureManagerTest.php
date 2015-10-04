<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Test;

use FeatureToggle\FeatureManager;
use FeatureToggle\FeatureRegistry;

/**
 * Test FeatureManager class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\FeatureManager
 */
class FeatureManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::isEnabled
     */
    public function testIsEnabled()
    {
        $FeatureMock = $this->getMock(
            '\FeatureToggle\Feature\BooleanFeature',
            array('isEnabled'),
            array('bar')
        );

        $FeatureMock->expects($this->once())
            ->method('isEnabled')
            ->with()
            ->will($this->returnValue(false));

        FeatureRegistry::add('bar', $FeatureMock);

        $this->assertFalse(FeatureManager::isEnabled('bar'));
    }
}
