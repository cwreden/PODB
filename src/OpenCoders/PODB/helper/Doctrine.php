<?php

namespace OpenCoders\PODB\helper;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Doctrine {

    static private $em = null;

    static private $isDevMode = false;

    static public function getEntityManager()
    {
        if (self::$em == null) {

            $paths = array(__DIR__ . "/../Entity");

            // the connection configuration
            $dbParams = include(__DIR__ . '/../../../../config/doctrine.local.php');

            $config = Setup::createAnnotationMetadataConfiguration($paths, self::$isDevMode);

            if (self::$isDevMode) {
                $cache = new ArrayCache();  // @ToDo: How does the Array Cache works?
            } else {
                $cache = new ApcCache();    // @ToDo: How does the APC Cache works?
            }
            $config->setMetadataCacheImpl($cache);
            $config->setQueryCacheImpl($cache);

            self::$em = EntityManager::create($dbParams, $config);
        }

        return self::$em;
    }

    static public function setDevMode($modeBoolean)
    {
        self::$isDevMode = $modeBoolean;
    }
} 