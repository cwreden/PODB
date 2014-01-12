<?php

use Luracast\Restler\Defaults;
use Luracast\Restler\Restler;

set_include_path('.'); // Remove default include_path so only using Composer include_path

require __DIR__ . '/../../src/autoload.php';

Defaults::$useUrlBasedVersioning = true;
//Defaults::$cacheDirectory = '/../../tmp/restler/cache';

$restler = new Restler();
$restler->setAPIVersion(1);
$restler->addAuthenticationClass('OpenCoders\Podb\Access\BasicAuthentication');

$restler->addFilterClass('OpenCoders\Podb\Filter\RateLimit');

$restler->addAPIClass('OpenCoders\Podb\Api\Users', '');
$restler->addAPIClass('OpenCoders\Podb\Api\Projects', '');
$restler->addAPIClass('OpenCoders\Podb\Api\Languages', '');
$restler->addAPIClass('OpenCoders\Podb\Api\Domains', '');
$restler->addAPIClass('OpenCoders\Podb\Api\DataSets', '');
$restler->addAPIClass('OpenCoders\Podb\Api\Translations', '');

$restler->handle();
