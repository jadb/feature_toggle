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

use DateTime;
use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\Feature\FeatureInterface;
use FeatureToggle\FeatureFactory;
use FeatureToggle\Strategy\AbstractStrategy;
use FeatureToggle\Strategy\ComparisonOperator\LowerThan;
use FeatureToggle\Strategy\DateTimeStrategy;
use FeatureToggle\Stub\ForTestingItShouldPushAnyCallableStrategy;

class FeatureFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itShouldDefaultToBooleanFeature()
    {
        $result = FeatureFactory::buildFeature('Test');
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

        // @codingStandardsIgnoreStart
        $anonymousMethod = [
            new class
            {
                public function foo(FeatureInterface $feature, array $args = [])
                {
                    return current($args);
                }

                public function serialize(): string
                {
                    return '';
                }

                public function unserialize($serialized)
                {
                }

            },
            'foo'
        ];

        $anonymousStrategy = new class extends AbstractStrategy {
            public function __invoke(FeatureInterface $feature, array $args = []): bool
            {
                return current($args);
            }

            public function serialize(): string
            {
                return '';
            }

            public function unserialize($serialized)
            {
            }
        };
        // @codingStandardsIgnoreEnd

        $function = '\FeatureToggle\Stub\forTestingItShouldPushAnyCallableStrategy';
        $method = [$this, 'forTestingItShouldPushAnyCallableStrategy'];
        $object = new ForTestingItShouldPushAnyCallableStrategy();
        $strategy = new DateTimeStrategy(new DateTime('tomorrow'), new LowerThan());

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

        $feature = FeatureFactory::buildFeature('Test', compact('type', 'strategies'));
        $this->assertCount(7, $feature->getStrategies());
    }

    public function forTestingItShouldPushAnyCallableStrategy()
    {
        return true;
    }
}
