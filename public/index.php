<?php

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


/**
 * @TODO extract controller
 */
$app->get('/', function () use ($app) {
    $app['session']->start();
    if (isset($_SESSION['attributes']) && isset($_SESSION['attributes']['locked']) && $_SESSION['attributes']['locked'] === true || $app['session']->get('locked')) {
        return $app['twig']->render('lockscreen.html');
    }
    return $app['twig']->render('base.html');
});

/**
 * @Debug
 */
$app->get('/lock', function () use ($app) {
    $app['session']->set('locked', true);
    return true;
});

/**
 * @Debug
 */
$app->get('/unlock', function () use ($app) {
    $app['session']->set('locked', false);
    return true;
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


$app->get('/menu', function () use ($app) {
    return new JsonResponse(array(
        array(
            'title' => 'Dashboard',
            'fa' => 'fa-dashboard',
            'route' => '#/dashboard'
        ),
        array(
            'title' => 'Dashboard',
            'fa' => 'fa-dashboard',
            'sub-menu' => array(
                array(
                    'title' => 'Dashboard',
                    'fa' => 'fa-dashboard',
                    'route' => '#/dashboard'
                )
            )
        )
    ));
});

$app->run();