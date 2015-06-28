<?php
use OpenCoders\Podb\PODBApplication;

define ("APPLICATION_ROOT", realpath(__DIR__."/.."));

require_once __DIR__ . '/../vendor/autoload.php';

$configuration = include(__DIR__ . '/../config/podb.config.php');

$app = new PODBApplication($configuration);
$app->run();
