<?php declare(strict_types = 1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Strategy\ComparisonOperator;

abstract class AbstractComparisonOperator implements ComparisonOperatorInterface
{

    protected $value;

    /**
     * {@inheritdoc}
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->value = $serialized;
    }
}
