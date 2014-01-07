<?php

namespace OpenCoders\PODB\helper;


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
            self::$em = EntityManager::create($dbParams, $config);
        }

        return self::$em;
    }

    static public function setDevMode($modeBoolean)
    {
        self::$isDevMode = $modeBoolean;
    }
} 