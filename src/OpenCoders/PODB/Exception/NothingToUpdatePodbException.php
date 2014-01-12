<?php

namespace OpenCoders\Podb\Exception;

class NothingToUpdatePodbException extends PodbException
{
    public function __construct($message = "There is nothing to update.", $code = 0, \Exception $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
} 