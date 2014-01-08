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

    public function isAuthenticated()
    {
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] ? true : false;
    }

    public function setAuthenticated($isAuthenticated = false)
    {
        $_SESSION['authenticated'] = $isAuthenticated;
    }
} 