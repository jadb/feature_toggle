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

use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\FeatureRegistry;
use InvalidArgumentException;

class FeatureRegistryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        FeatureRegistry::flush();
    }

    /**
     * @test
     */
    public function itShouldAddAndReturnDifferentInstances()
    {
        $feature = new BooleanFeature('foo');
        FeatureRegistry::add('Test', $feature);
        $result = FeatureRegistry::get('Test');
        $this->assertNotSame($feature, $result);
        $this->assertInstanceOf(BooleanFeature::class, $result);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Duplicate feature identifier.
     */
    public function itShouldNotAllowDuplicateFeatureNames()
    {
        $feature = new BooleanFeature('foo');
        FeatureRegistry::add('Test Feature', $feature);
        FeatureRegistry::add('Test Feature', $feature);
    }

    /**
     * @test
     */
    public function itShouldDelegate()
    {
        $feature = new BooleanFeature('foo');
        FeatureRegistry::add('Test Feature', $feature);
        $this->assertTrue(FeatureRegistry::check('Test Feature'));
        $this->assertFalse(FeatureRegistry::check('Undefined Feature'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function itShouldFlushTheRegistry()
    {
        $feature = new BooleanFeature('Test Feature');
        FeatureRegistry::add('Test Feature', $feature);
        FeatureRegistry::flush();
        FeatureRegistry::get('Test Feature');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unknown feature identifier.
     */
    public function itShouldNotFailSilentlyOnUndefinedFeatures()
    {
        FeatureRegistry::get('Undefined Feature');
    }

    /**
     * @test
     */
    public function itShouldCreateAndAddFeatureToRegistry()
    {
        $feature = FeatureRegistry::init('Test Feature 1');
        $expected = BooleanFeature::class;
        $this->assertInstanceOf($expected, $feature);
    }
}
