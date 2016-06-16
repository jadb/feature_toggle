<?php declare(strict_types=1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle;

use FeatureToggle\Feature\FeatureInterface;
use FeatureToggle\Feature\StrictBooleanFeature;
use FeatureToggle\Strategy\AbstractStrategy;

/**
 * Boolean feature test class.
 */
class StrictBooleanFeatureTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \FeatureToggle\Feature\StrictBooleanFeature
     */
    private $feature;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->feature = new StrictBooleanFeature('foo', 'bar');
    }

    /**
     * @test
     */
    public function itShouldBeConsideredEnabledWhenAllStrategiesArePassing()
    {
        $this->assertFalse($this->feature->isEnabled());

        $result = $this->feature->enable();
        $this->assertFalse($this->feature->isEnabled());
        $this->assertTrue($result->isEnabled());

        // @codingStandardsIgnoreStart
        $strategy1 = new class extends AbstractStrategy {
            public function __invoke(FeatureInterface $Feature, array $args = []): bool
            {
                return true;
            }
        };

        $strategy2 = new class extends AbstractStrategy {
            public function __invoke(FeatureInterface $Feature, array $args = []): bool
            {
                return true;
            }
        };
        // @codingStandardsIgnoreEnd

        $result = $this->feature
            ->pushStrategy($strategy1)
            ->pushStrategy($strategy2);

        $this->assertTrue($result->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldBeConsideredDisabledWhenJustOneStrategyFails()
    {
        // @codingStandardsIgnoreStart
        $strategy1 = new class extends AbstractStrategy {
            public function __invoke(FeatureInterface $Feature, array $args = []): bool
            {
                return true;
            }
        };

        $strategy2 = new class extends AbstractStrategy {
            public function __invoke(FeatureInterface $Feature, array $args = []): bool
            {
                return false;
            }
        };
        // @codingStandardsIgnoreEnd

        $result = $this->feature
            ->pushStrategy($strategy1)
            ->pushStrategy($strategy2);

        $this->assertFalse($result->isEnabled());
    }
}
