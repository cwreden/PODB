<?php

namespace OpenCoders\Podb\Exception;

use Exception;

class InvalidUsernamePasswordCombinationException extends Exception
{
    public function __construct(
        $message = 'Invalid username password combination!',
        $code = 401,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
