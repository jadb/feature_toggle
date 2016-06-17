<?php declare(strict_types=1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Test;

use FeatureToggle\Feature\DisabledFeature;
use FeatureToggle\Feature\EnabledFeature;
use FeatureToggle\FeatureManager;
use FeatureToggle\FeatureRegistry;

class FeatureManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itShouldLocateAndDelegate()
    {
        FeatureRegistry::add('foo', new EnabledFeature('foo'));
        FeatureRegistry::add('bar', new DisabledFeature('bar'));
        $this->assertTrue(FeatureManager::isEnabled('foo'));
        $this->assertFalse(FeatureManager::isEnabled('bar'));
    }
}
