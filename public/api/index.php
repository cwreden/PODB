<?php

use Luracast\Restler\Defaults;
use Luracast\Restler\Restler;

set_include_path('.'); // Remove default include_path so only using Composer include_path

require __DIR__ . '/../../src/autoload.php';

Defaults::$useUrlBasedVersioning = true;
//Defaults::$cacheDirectory = '/../../tmp/restler/cache';

$restler = new Restler();
$restler->setAPIVersion(1);
$restler->addAuthenticationClass('OpenCoders\PODB\access\Authentication');

$restler->addFilterClass('OpenCoders\PODB\filter\RateLimit');

$restler->addAPIClass('OpenCoders\PODB\API\Users', '');
$restler->addAPIClass('OpenCoders\PODB\API\Projects', '');
$restler->addAPIClass('OpenCoders\PODB\API\Languages', '');
$restler->addAPIClass('OpenCoders\PODB\API\Domains', '');
$restler->addAPIClass('OpenCoders\PODB\API\DataSets', '');
$restler->addAPIClass('OpenCoders\PODB\API\Translations', '');

$restler->handle();
