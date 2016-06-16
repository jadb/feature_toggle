<?php declare(strict_types=1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Strategy;

use FeatureToggle\Feature\FeatureInterface;

/**
 * User agent strategy.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Strategy
 * @author Jad Bitar <jadbitar@mac.com>
 */
class UserAgentStrategy extends AbstractStrategy
{
    /**
     * Allowed user agents' patterns.
     *
     * @var array
     */
    protected $patterns;

    /**
     * Constructor.
     *
     * @param string[] $patterns Allowed user agents' patterns.
     */
    public function __construct(array $patterns)
    {
        $this->patterns = $patterns;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(FeatureInterface $Feature, array $args = []): bool
    {
        $userAgent = $this->getUserAgent();

        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns current user agent.
     *
     * @return string
     */
    public function getUserAgent(): string
    {
        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return '';
        }

        return $_SERVER['HTTP_USER_AGENT'];
    }
}
