<?php

namespace OpenCoders\PODB\access;


class Authentication {

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