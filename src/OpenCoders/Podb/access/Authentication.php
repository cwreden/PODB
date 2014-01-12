<?php

namespace OpenCoders\Podb\Access;


use Luracast\Restler\iAuthenticate;

class Authentication implements iAuthenticate{

    /**
     * Access verification method.
     *
     * API access will be denied when this method returns false
     *
     * @return boolean true when api access is allowed false otherwise
     */
    public function __isAllowed()
    {
//        var_dump($this->getNeededPermissions());

        // TODO Logic

        return true;
    }
} 