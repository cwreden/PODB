<?php
// bootstrap.php
// Include Composer Autoload (relative to project root).
require_once "src/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("src/OpenCoders/PODB/Entity");
$isDevMode = false;

// the connection configuration
$dbParams = include('config/doctrine.local.php');

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
