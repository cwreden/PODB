<?php

namespace OpenCoders\Podb\Api;

/**
 * Class ApiUrl
 * @package OpenCoders\Podb\Api
 * @deprecated
 */
class ApiUrl
{
    public static function getBaseApiUrl()
    {
        return self::getHostAdress() . "/api";
    }

    public static function getHostAdress()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ?
            "https://" : "http://";
        return $protocol . $_SERVER['HTTP_HOST'];
    }
}
