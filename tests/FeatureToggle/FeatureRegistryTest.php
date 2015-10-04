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

/**
 * Test FeatureRegistry class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\FeatureRegistry
 */
class FeatureRegistryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        FeatureRegistry::flush();
    }

    /**
     * @covers ::add
     */
    public function testAdd()
    {
        $Feature = new Feature\BooleanFeature('Test Feature');
        FeatureRegistry::add('Test Feature', $Feature);

        $expected = $Feature;
        $actual = FeatureRegistry::get('Test Feature');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::add
     * @expectedException \FeatureToggle\Exception\DuplicateFeatureException
     * @expectedExceptionMessage Duplicate feature identifier.
     */
    public function testAddThrowsException()
    {
        $Feature = new Feature\BooleanFeature('Test Feature');
        FeatureRegistry::add('Test Feature', $Feature);
        FeatureRegistry::add('Test Feature', $Feature);
    }

    /**
     * @covers ::check
     */
    public function testCheck()
    {
        $Feature = new Feature\BooleanFeature('Test Feature');
        FeatureRegistry::add('Test Feature', $Feature);

        $this->assertTrue(FeatureRegistry::check('Test Feature'));
        $this->assertFalse(FeatureRegistry::check('Undefined Feature'));
    }

    /**
     * @covers ::flush
     */
    public function testFlush()
    {
        $Feature = new Feature\BooleanFeature('Test Feature');
        FeatureRegistry::add('Test Feature', $Feature);

        FeatureRegistry::flush();

        $this->setExpectedException('\FeatureToggle\Exception\FeatureNotFoundException');

        FeatureRegistry::get('Test Feature');
    }

    /**
     * @covers ::get
     */
    public function testGet()
    {
        $Feature = new Feature\BooleanFeature('Test Feature');
        FeatureRegistry::add('Test Feature', $Feature);

        $expected = '\FeatureToggle\Feature\BooleanFeature';
        $actual = FeatureRegistry::get('Test Feature');

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @covers ::get
     * @expectedException \FeatureToggle\Exception\FeatureNotFoundException
     * @expectedExceptionMessage Unknown feature identifier.
     */
    public function testGetThrowsException()
    {
        FeatureRegistry::get('Undefined Feature');
    }

    /**
     * @covers ::init
     */
    public function testInit()
    {
        $Feature = FeatureRegistry::init('Test Feature 1');

        $expected = '\FeatureToggle\Feature\BooleanFeature';
        $actual = $Feature;

        $this->assertInstanceOf($expected, $actual);
    }
}
