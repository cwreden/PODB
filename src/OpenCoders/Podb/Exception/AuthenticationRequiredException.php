<?php

namespace OpenCoders\Podb\Exception;


use Exception;

class AuthenticationRequiredException extends Exception
{
    function __construct($message = 'Authentication required!', $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}