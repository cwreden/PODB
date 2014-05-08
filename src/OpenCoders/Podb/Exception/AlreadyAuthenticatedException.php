<?php

namespace OpenCoders\Podb\Exception;


use Exception;

class AlreadyAuthenticatedException extends Exception
{
    function __construct($message = 'Already Authenticated!', $code = 409, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 