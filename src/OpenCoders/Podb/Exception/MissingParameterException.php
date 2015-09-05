<?php

namespace OpenCoders\Podb\Exception;

use Exception;

class MissingParameterException extends Exception
{
    public function __construct($parameterName = null, $code = 400, Exception $previous = null)
    {
        $message = 'Missing parameter';
        if ($message !== null) {
            $message .= ' ' . $parameterName;
        }
        parent::__construct($message, $code, $previous);
    }
}
