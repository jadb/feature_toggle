<?php
namespace FeatureToggle\Exception;

use Exception;

class FeatureNotFoundException extends Exception
{
    protected $code = 404;
    protected $message = 'Unknown feature identifier.';
}
