<?php

namespace OpenCoders\Podb\Persistence;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use SimpleThings\EntityAudit\AuditConfiguration;
use SimpleThings\EntityAudit\AuditManager;

/**
 * Class Doctrine
 *
 * Command line tool support only
 *
 * @package OpenCoders\Podb\Persistence
 */
class Doctrine
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    static private $em = null;

    /**
     * @var \SimpleThings\EntityAudit\AuditManager
     */
    static private $am = null;

    /**
     * @var \Doctrine\Common\EventManager
     */
    static private $evm = null;

    /**
     * configuration parameter for EntityManager instanciation (if you want to run doctrine in development mode)
     * @var bool
     */
    static private $isDevMode = false;

    /**
     * Returns a singleton instance of the Doctrine EntityManager
     *
     * @return \Doctrine\ORM\EntityManager
     * @deprecated
     */
    static public function getEntityManager()
    {
        if (self::$em == null) {
            $dbParams = include(__DIR__ . '/../../../../config/podb.config.php');
            $pathToEntities = array(__DIR__ . "/Entity");

            self::getAuditManager();

            $config = new Configuration();

            $config->setProxyDir(__DIR__ . '/../../../../tmp/doctrine/proxy');
            $config->setProxyNamespace('OpenCoders\Podb\Proxies');
            $config->setAutoGenerateProxyClasses(self::$isDevMode);

            $driverImpl = $config->newDefaultAnnotationDriver($pathToEntities);
            $config->setMetadataDriverImpl($driverImpl);

//            $cache = (self::$isDevMode ? new ArrayCache() : new ApcCache()); // @ToDo: How does the Array Cache and APC Cache works?
//            $config->setMetadataCacheImpl($cache);
//            $config->setQueryCacheImpl($cache);

            self::$em = EntityManager::create($dbParams['db.options'], $config, self::getEventManager());
        }

        return self::$em;
    }

    /**
     * @return AuditManager
     * @deprecated
     */
    static public function getAuditManager ()
    {
        if (self::$am == null) {
            $auditConfig = new AuditConfiguration();
            $auditConfig->setAuditedEntityClasses(array(
                'OpenCoders\Podb\Persistence\Entity\User',
                'OpenCoders\Podb\Persistence\Entity\Language',
                'OpenCoders\Podb\Persistence\Entity\Project',
                'OpenCoders\Podb\Persistence\Entity\Domain',
                'OpenCoders\Podb\Persistence\Entity\Message',
                'OpenCoders\Podb\Persistence\Entity\Translation',
            ));
            $evm = self::getEventManager();
            $am = new AuditManager($auditConfig);
            $am->registerEvents($evm);
            self::$am = $am;
        }
        return self::$am;
    }

    /**
     * @return EventManager
     */
    static private function getEventManager()
    {
        if (self::$evm == null) {
            $evm = new EventManager();
            self::$evm = $evm;
        }
        return self::$evm;
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