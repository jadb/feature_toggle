<?php declare(strict_types=1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Test\Strategy;

use DateTime;
use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\Strategy\DateTimeRangeStrategy;

/**
 * DateTimeRange strategy test class.
 */
class DateTimeRangeStrategyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itShouldBeConsideredEnabledWhenDateIsWithinRangeNonInclusive()
    {
        $strategy = new DateTimeRangeStrategy(
            new DateTime('-1 week'),
            new DateTime('+1 week')
        );

        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }

    /**
     * @test
     */
    public function itShouldBeConsideredEnabledWhenDateIsWithinRange()
    {
        $strategy = new DateTimeRangeStrategy(
            new DateTime('-1 week'),
            new DateTime('1 second'),
            true
        );

        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }

    /**
     * @test
     */
    public function itShouldBeConsideredDisabledWhenDateIsNotWithinRangeNotInclusive()
    {
        $strategy = new DateTimeRangeStrategy(
            new DateTime('-1 week'),
            new DateTime('-1 minute')
        );

        $this->assertFalse($strategy(new BooleanFeature('foo')));
    }

    /**
     * @test
     */
    public function itShouldBeConsideredDisabledWhenDateIsNotWithinRange()
    {
        $strategy = new DateTimeRangeStrategy(
            new DateTime('-1 week'),
            new DateTime('1 second'),
            true
        );

        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }
}
