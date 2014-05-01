<?php

use OpenCoders\Podb\Provider\ACLControllerProvider;
use OpenCoders\Podb\Provider\AuditControllerProvider;
use OpenCoders\Podb\Provider\AuditServiceProvider;
use OpenCoders\Podb\Provider\AuthenticationControllerProvider;
use OpenCoders\Podb\Provider\AuthenticationServiceProvider;
use OpenCoders\Podb\Provider\CategoryControllerProvider;
use OpenCoders\Podb\Provider\CategoryServiceProvider;
use OpenCoders\Podb\Provider\DataSetControllerProvider;
use OpenCoders\Podb\Provider\DataSetServiceProvider;
use OpenCoders\Podb\Provider\IndexControllerProvider;
use OpenCoders\Podb\Provider\LanguageControllerProvider;
use OpenCoders\Podb\Provider\LanguageServiceProvider;
use OpenCoders\Podb\Provider\ACLServiceProvider;
use OpenCoders\Podb\Provider\ProjectControllerProvider;
use OpenCoders\Podb\Provider\ProjectServiceProvider;
use OpenCoders\Podb\Provider\RequestRateLimitServiceProvider;
use OpenCoders\Podb\Provider\TranslationControllerProvider;
use OpenCoders\Podb\Provider\TranslationServiceProvider;
use OpenCoders\Podb\Provider\UserControllerProvider;
use OpenCoders\Podb\Provider\UserServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

define ("APPLICATION_ROOT", realpath(__DIR__."/.."));

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\SessionServiceProvider());

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

$app->mount('', new IndexControllerProvider());
$app->mount('/user', new UserControllerProvider());
$app->mount('/project', new ProjectControllerProvider());
$app->mount('/language', new LanguageControllerProvider());
$app->mount('/category', new CategoryControllerProvider());
$app->mount('/dataSet', new DataSetControllerProvider());
$app->mount('/translation', new TranslationControllerProvider());
$app->mount('/audit', new AuditControllerProvider());
$app->mount('/acl', new ACLControllerProvider());
$app->mount('/auth', new AuthenticationControllerProvider());


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