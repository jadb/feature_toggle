<?php declare(strict_types=1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Test\Feature;

use FeatureToggle\Feature\BooleanFeature;

class BooleanFeatureTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \FeatureToggle\Feature\BooleanFeature
     */
    private $feature;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->feature = new BooleanFeature('foo', 'bar');
    }

    /**
     * @test
     */
    public function itShouldDisableACloneOfTheCurrentFeature()
    {
        $feature = $this->feature->enable();
        $result = $feature->disable();
        $this->assertTrue($feature->isEnabled());
        $this->assertFalse($result->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldEnableACloneOfTheCurrentFeature()
    {
        $result = $this->feature->enable();
        $this->assertFalse($this->feature->isEnabled());
        $this->assertTrue($result->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldTellIfTheFeatureIsEnabledOrNot()
    {
        $this->assertFalse($this->feature->isEnabled());

        $result = $this->feature->enable();
        $this->assertFalse($this->feature->isEnabled());
        $this->assertTrue($result->isEnabled());
    }
}
