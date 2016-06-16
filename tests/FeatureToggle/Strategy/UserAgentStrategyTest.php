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

use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\Strategy\UserAgentStrategy;

/**
 * Boolean feature test class.
 */
class UserAgentStrategyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \FeatureToggle\Strategy\UserAgentStrategy
     */
    private $strategy;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->strategy = new UserAgentStrategy(['/foo/', '/bar/']);
    }

    /**
     * @test
     */
    public function itShouldNotMatchAnyPattern()
    {
        $strategy = $this->strategy;
        $this->assertFalse($strategy(new BooleanFeature('foo')));

        $_SERVER['HTTP_USER_AGENT'] = 'foo';
        $this->assertTrue($strategy(new BooleanFeature('foo')));
    }
}
