<?php declare(strict_types = 1);


namespace FeatureToggle\Exception;

use RuntimeException;

class UnknownFeatureException extends RuntimeException
{
    protected $code = 500;
    protected $message = 'Unknown feature identifier.';
}
