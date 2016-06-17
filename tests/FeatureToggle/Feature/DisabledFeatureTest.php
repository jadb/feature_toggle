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

use FeatureToggle\Feature\DisabledFeature;

/**
 * Disabled feature test class.
 */
class DisabledFeatureTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itShouldAlwaysReturnFalse()
    {
        $this->assertFalse((new DisabledFeature('foo', 'bar'))->isEnabled());
    }
}
