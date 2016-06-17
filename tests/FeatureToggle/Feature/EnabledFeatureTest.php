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

use FeatureToggle\Feature\EnabledFeature;

/**
 * Enabled feature test class.
 */
class EnabledFeatureTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itShouldAlwaysReturnTrue()
    {
        $this->assertTrue((new EnabledFeature('foo', 'bar'))->isEnabled());
    }
}
