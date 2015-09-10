<?php

final class Bootstrapper
{

    private static $isBootstrapped = false;

    const ROOT_PATH = __DIR__;

    /**
     * set global constants and prepares the environment
     */
    public static function bootstrap()
    {
        if (!self::$isBootstrapped) {
            define('APPLICATION_ROOT', realpath(self::ROOT_PATH));
            self::$isBootstrapped = true;
        }
    }

    /**
     * @return array
     */
    public static function getConfig()
    {
        return include(__DIR__ . '/config/podb.config.php');
    }

    /**
     * @return \OpenCoders\Podb\PODBApplication
     */
    public static function getPODB()
    {
        self::bootstrap();
        return new \OpenCoders\Podb\PODBApplication(self::getConfig());
    }
}
