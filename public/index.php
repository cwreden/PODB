<?php
use OpenCoders\Podb\Application;

define ("APPLICATION_ROOT", realpath(__DIR__."/.."));

require_once __DIR__ . '/../vendor/autoload.php';

$configuration = include(__DIR__ . '/../config/podb.config.php');

$app = new Application($configuration);
$app->run();
