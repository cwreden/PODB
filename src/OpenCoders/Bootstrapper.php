<?php

namespace OpenCoders;

final class Bootstrapper
{

    private static $isBootstrapped = false;

    /**
     * set global constants and prepares the environment
     */
    public static function bootstrap()
    {
        if (!self::$isBootstrapped) {
            define('APPLICATION_ROOT', self::getRootPath());
            self::$isBootstrapped = true;
        }
    }

    /**
     * @return array
     */
    public static function getConfig()
    {
        return include(self::getRootPath() . '/config/podb.config.php');
    }

    /**
     * @return \OpenCoders\Podb\PODBApplication
     */
    public static function getPODB()
    {
        self::bootstrap();
        return new \OpenCoders\Podb\PODBApplication(self::getConfig());
    }

    public static function getRootPath()
    {
        return realpath(__DIR__ . '/../..');
    }
}
