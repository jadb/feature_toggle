<?php
namespace FeatureToggle\Exception;

use Exception;

class DuplicateFeatureException extends Exception
{
    protected $code = 400;
    protected $message = 'Duplicate feature identifier.';
}
