<?php

namespace OpenCoders\PODB\helper;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;

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
            $pathToEntities = array(__DIR__ . "/../Entity");

            $config = new Configuration();

            $config->setProxyDir(__DIR__ . '/../../../../tmp/doctrine/proxy');
            $config->setProxyNamespace('OpenCoders\PODB\Proxies');
            $config->setAutoGenerateProxyClasses(self::$isDevMode);

            $driverImpl = $config->newDefaultAnnotationDriver($pathToEntities);
            $config->setMetadataDriverImpl($driverImpl);

//            $cache = (self::$isDevMode ? new ArrayCache() : new ApcCache()); // @ToDo: How does the Array Cache and APC Cache works?
//            $config->setMetadataCacheImpl($cache);
//            $config->setQueryCacheImpl($cache);

            self::$em = EntityManager::create($dbParams, $config, new EventManager());
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