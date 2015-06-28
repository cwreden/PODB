<?php
use OpenCoders\Podb\Application;

define ("APPLICATION_ROOT", realpath(__DIR__."/.."));

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application(array(
    'debug' => true
));
$app->run();
