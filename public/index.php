<?php

use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Provider\AuditServiceProvider;
use OpenCoders\Podb\Provider\CategoryServiceProvider;
use OpenCoders\Podb\Provider\DataSetServiceProvider;
use OpenCoders\Podb\Provider\IndexControllerProvider;
use OpenCoders\Podb\Provider\ACLServiceProvider;

define ("APPLICATION_ROOT", realpath(__DIR__."/.."));

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
// TODO Doctrine via silex
//$app->register(new Silex\Provider\DoctrineServiceProvider());

$app->register(
    new \Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => APPLICATION_ROOT . '/src/Views',
        'twig.options' => array('cache' => APPLICATION_ROOT . '/data/twig'),
    )
);

$app->register(
    new \Silex\Provider\MonologServiceProvider(),
    array(
        'monolog.logfile' => APPLICATION_ROOT . "/data/application.log"
    )
);

// Services
$app->register(new \OpenCoders\Podb\Provider\Service\ConfigurationServiceProvider());
$app->register(new \OpenCoders\Podb\Provider\Service\UserServiceProvider());
$app->register(new \OpenCoders\Podb\Provider\Service\ProjectServiceProvider());
$app->register(new \OpenCoders\Podb\Provider\Service\LanguageServiceProvider());
$app->register(new CategoryServiceProvider());
$app->register(new DataSetServiceProvider());
$app->register(new \OpenCoders\Podb\Provider\Service\TranslationServiceProvider());
$app->register(new AuditServiceProvider());
$app->register(new ACLServiceProvider());
$app->register(new \OpenCoders\Podb\Provider\Service\AuthenticationServiceProvider());
$app->register(new \OpenCoders\Podb\Provider\Service\RequestRateLimitServiceProvider());
$app->register(new \OpenCoders\Podb\Provider\Service\ErrorHandlerServiceProvider());

// Page
$app->mount('', new IndexControllerProvider());

// REST
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\UserControllerProvider());
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\ProjectControllerProvider());
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\LanguageControllerProvider());
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\CategoryControllerProvider());
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\DataSetControllerProvider());
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\TranslationControllerProvider());
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\AuditControllerProvider());
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\ACLControllerProvider());
$app->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\AuthenticationControllerProvider());


// TODO DoctrineServiceProvider
$app['entityManager'] = $app->share(function () {
    return Doctrine::getEntityManager();
});

/**
 * Put payload to request part
 * TODO extract in service
 */
$app->before(function (\Symfony\Component\HttpFoundation\Request $request) {
    if ($request->getContentType() === 'json') {
        $request->request->add(json_decode($request->getContent(), true));
    }
});

$app->run();