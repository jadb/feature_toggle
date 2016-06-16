<?php
declare(strict_types = 1);

namespace FeatureToggle\Strategy\ComparisonOperator;

interface ComparisonOperatorInterface
{

    public function getValue(): string;
    public function __toString(): string;
}
