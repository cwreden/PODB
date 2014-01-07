<?php
// bootstrap.php
// Include Composer Autoload (relative to project root).
require_once "src/autoload.php";

$entityManager = \OpenCoders\PODB\helper\Doctrine::getEntityManager();
