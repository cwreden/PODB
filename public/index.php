<?php

use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Provider\AuditServiceProvider;
use OpenCoders\Podb\Provider\AuthenticationServiceProvider;
use OpenCoders\Podb\Provider\CategoryServiceProvider;
use OpenCoders\Podb\Provider\DataSetServiceProvider;
use OpenCoders\Podb\Provider\IndexControllerProvider;
use OpenCoders\Podb\Provider\LanguageServiceProvider;
use OpenCoders\Podb\Provider\ACLServiceProvider;
use OpenCoders\Podb\Provider\ProjectServiceProvider;
use OpenCoders\Podb\Provider\RequestRateLimitServiceProvider;
use OpenCoders\Podb\Provider\TranslationServiceProvider;
use OpenCoders\Podb\Provider\UserServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

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
$app->register(new UserServiceProvider());
$app->register(new ProjectServiceProvider());
$app->register(new LanguageServiceProvider());
$app->register(new CategoryServiceProvider());
$app->register(new DataSetServiceProvider());
$app->register(new TranslationServiceProvider());
$app->register(new AuditServiceProvider());
$app->register(new ACLServiceProvider());
$app->register(new AuthenticationServiceProvider());
$app->register(new RequestRateLimitServiceProvider());

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


$app['entityManager'] = $app->share(function () {
    return Doctrine::getEntityManager();
});

$app->error(function (Exception $e, $code) {
    if ($e->getCode() !== 0) {
        $code = $e->getCode();
    }
    return new \Symfony\Component\HttpFoundation\Response('ERROR HANDLER: '.$e->getMessage(), $code);
});

/**
 * @Debug
 */
$app->get('/test', function () use ($app) {
    $app['session']->start();
    return new JsonResponse($_SESSION);
});

$app->get('/clean', function () use ($app) {
    $app['session']->clear();
    unset($_SESSION['attributes']);
    return new JsonResponse($_SESSION);
});

$app->run();