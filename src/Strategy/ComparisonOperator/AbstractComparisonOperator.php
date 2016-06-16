<?php
declare(strict_types = 1);

namespace FeatureToggle\Strategy\ComparisonOperator;

abstract class AbstractComparisonOperator implements ComparisonOperatorInterface
{

    protected $value;

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
