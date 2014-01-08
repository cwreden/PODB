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
        if ($_SESSION['attributes'][$key]) {
            return $_SESSION['attributes'][$key];
        }
        return null;
    }

    public function removeAttribute($key)
    {
        if (isset($_SESSION['attributes'][$key])) {
            unset($_SESSION['attributes'][$key]);
        }
    }

    public function isAuthenticated()
    {
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] ? true : false;
    }

    public function setAuthenticated($isAuthenticated = false)
    {
        $_SESSION['authenticated'] = $isAuthenticated;
    }
} 