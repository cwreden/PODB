<?php

namespace OpenCoders\Podb\Exception;


use Exception;

class InactiveUserAccountException extends Exception
{
    function __construct($message = 'Inactive user account!', $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 