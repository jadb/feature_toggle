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
 */
class UserAgentStrategy extends AbstractStrategy
{
    /**
     * Allowed user agents' patterns.
     *
     * @var array
     */
    private $patterns;

    /**
     * Constructor.
     *
     * @param string[] $patterns Allowed user agents' patterns.
     */
    final public function __construct(array $patterns)
    {
        $this->patterns = $patterns;
    }

    /**
     * {@inheritdoc}
     */
    final public function __invoke(FeatureInterface $Feature, array $args = []): bool
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
    protected function getUserAgent(): string
    {
        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return '';
        }

        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return json_encode($this->patterns);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->patterns = json_decode($serialized, true);
    }
}
