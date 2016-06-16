<?php declare(strict_types = 1);


namespace FeatureToggle\Exception;

use InvalidArgumentException;

class UnsupportedComparisonOperatorException extends InvalidArgumentException
{
    protected $code = 500;
    protected $message = 'Unsupported comparison operator.';
}
