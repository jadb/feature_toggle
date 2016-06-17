<?php declare(strict_types = 1);


namespace FeatureToggle\Exception;

use InvalidArgumentException;

class DuplicateFeatureException extends InvalidArgumentException
{
    protected $code = 500;
    protected $message = 'Duplicate feature identifier.';
}
