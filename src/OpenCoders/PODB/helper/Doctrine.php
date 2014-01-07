<?php

namespace OpenCoders\PODB\helper;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Doctrine
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    static private $em = null;

    /**
     * configuration parameter for EntityManager instanciation (if you want to run doctrine in development mode)
     * @var bool
     */
    static private $isDevMode = false;

    /**
     * Returns a singleton instance of the Doctrine EntityManager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    static public function getEntityManager()
    {
        if (self::$em == null) {
            $dbParams = include(__DIR__ . '/../../../../config/doctrine.local.php');
            $paths = array(__DIR__ . "/../Entity");

            $cache = (self::$isDevMode ? new ArrayCache() : new ApcCache()); // @ToDo: How does the Array Cache and APC Cache works?

            $config = Setup::createAnnotationMetadataConfiguration($paths, self::$isDevMode, null, $cache, false);

            self::$em = EntityManager::create($dbParams, $config);
        }

        return self::$em;
    }

    /**
     * Set true, if you want to run Doctrine's EntityManager in development mode (call this method before calling getEntityManager)
     * @param boolean $modeBoolean
     */
    static public function setDevMode($modeBoolean)
    {
        self::$isDevMode = $modeBoolean;
    }
} 