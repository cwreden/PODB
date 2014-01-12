<?php
// bootstrap.php
// Include Composer Autoload (relative to project root).
require_once "src/autoload.php";

$entityManager = \OpenCoders\Podb\Helper\Doctrine::getEntityManager();
