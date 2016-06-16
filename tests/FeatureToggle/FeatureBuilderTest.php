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

use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\Feature\FeatureInterface;
use FeatureToggle\Strategy\AbstractStrategy;
use FeatureToggle\Strategy\DateTimeStrategy;
use FeatureToggle\Stub\ForTestingItShouldPushAnyCallableStrategy;

/**
 * Test FeatureBuilder class.
 *
 * @package FeatureToggle
 * @author Jad Bitar <jadbitar@mac.com>
 * @coversDefaultClass \FeatureToggle\FeatureBuilder
 */
class FeatureBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itShouldDefaultToBooleanFeature()
    {
        $result = FeatureBuilder::buildFeature('Test');
        $this->assertInstanceOf(BooleanFeature::class, $result);
    }

    /**
     * @test
     */
    public function itShouldPushAnyCallableStrategy()
    {
        $anonymousFunction = function (FeatureInterface $feature, array $args = []) {
            return current($args);
        };

        $anonymousMethod = [new class {
            public function foo(FeatureInterface $feature, array $args = []) {
                return current($args);
            }
        }, 'foo'];

        $anonymousStrategy = new class extends AbstractStrategy {
            public function __invoke(FeatureInterface $feature, array $args = []): bool
            {
                return current($args);
            }
        };

        $function = '\FeatureToggle\Stub\forTestingItShouldPushAnyCallableStrategy';
        $method = [$this, 'forTestingItShouldPushAnyCallableStrategy'];
        $object = new ForTestingItShouldPushAnyCallableStrategy();
        $strategy = new DateTimeStrategy(date('Y-m-d', strtotime('tomorrow')), '<');

        $type = 'strictBoolean';
        $strategies = [
            $anonymousFunction,
            $anonymousMethod,
            $anonymousStrategy,
            $function,
            $method,
            $object,
            $strategy,
        ];

        $feature = FeatureBuilder::buildFeature('Test', compact('type', 'strategies'));
        $this->assertCount(7, $feature->getStrategies());
    }

    public function forTestingItShouldPushAnyCallableStrategy() {
        return true;
    }
}
