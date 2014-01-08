<?php

namespace OpenCoders\PODB\session;


class Session {

    function __construct()
    {
        if (!isset($_SESSION['attributes'])) {
            $_SESSION['attributes'] = array();
        }
    }

    public function setAttribute($key, $attribute)
    {
        $_SESSION['attributes'][$key] = $attribute;
    }

    public function getAttribute($key)
    {
        return $_SESSION['attributes'][$key];
    }

    public function removeAttribute($key)
    {
        unset($_SESSION['attributes'][$key]);
    }
} 