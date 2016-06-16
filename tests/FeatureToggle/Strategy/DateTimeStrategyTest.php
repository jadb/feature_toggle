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
use FeatureToggle\Strategy\ComparisonOperator\Equal;
use FeatureToggle\Strategy\ComparisonOperator\GreaterThan;
use FeatureToggle\Strategy\ComparisonOperator\GreaterThanEqual;
use FeatureToggle\Strategy\ComparisonOperator\LowerThan;
use FeatureToggle\Strategy\ComparisonOperator\LowerThanEqual;
use FeatureToggle\Strategy\DateTimeStrategy;

/**
 * DateTime strategy test class.
 */
class DateTimeStrategyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itShouldBeConsideredEnabledWhenDateIsEqual()
    {
        $strategy = new DateTimeStrategy(new DateTime('now'), new Equal());
        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }

    /**
     * @test
     */
    public function itShouldBeConsideredEnabledWhenDateIsGreaterThan()
    {
        $strategy = new DateTimeStrategy(new DateTime('yesterday'), new GreaterThan());
        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }

    /**
     * @test
     */
    public function itShouldBeConsideredEnabledWhenDateIsLowerThan()
    {
        $strategy = new DateTimeStrategy(new DateTime('tomorrow'), new LowerThan());
        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }

    /**
     * @test
     */
    public function itShouldBeConsideredEnabledWhenDateIsGreaterThanOrEqual()
    {
        $strategy = new DateTimeStrategy(new DateTime('now'), new GreaterThanEqual());
        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }

    /**
     * @test
     */
    public function itDefaultsToUsingGreaterThanOrEqualComparisonOperator()
    {
        $strategy = new DateTimeStrategy(new DateTime('now'));
        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }

    /**
     * @test
     */
    public function itShouldBeConsideredEnabledWhenDateIsLowerThanOrEqual()
    {
        $strategy = new DateTimeStrategy(new DateTime('now'), new LowerThanEqual());
        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }
}
