<?php

namespace OpenCoders\Podb\Exception;


use Exception;

class EmptyParameterException extends PodbException {

    public function __construct($message = "Parameter not allowed to be empty.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}