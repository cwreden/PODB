<?php

namespace OpenCoders\Podb\Api;

/**
 * Class ApiUrl
 * @package OpenCoders\Podb\Api
 * @deprecated
 */
class ApiUrl {

    static public function getBaseApiUrl()
    {
        return self::getHostAdress() . "/api";
    }

    static public function getHostAdress()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol . $_SERVER['HTTP_HOST'];
    }

} 