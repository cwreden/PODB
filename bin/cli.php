
<?php
require __DIR__.'/../vendor/autoload.php';
(new \OpenCoders\Podb\PODBApplication(include(__DIR__ . '/../config/podb.config.php')))->runCli();