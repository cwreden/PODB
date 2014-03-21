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
    if ($app['session']->get('locked') === true) {
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

/**
 * Test implementation
 */
$app->post('/login', function () use ($app) {
    sleep(3);

    return new JsonResponse(array(
        'success' => true,
        'displayName' => 'Max'
    ));
});

/**
 * Test implementation
 */
$app->get('/logout', function () use ($app) {
    sleep(3);
    return new Symfony\Component\HttpFoundation\JsonResponse(array(
       'success' => true
   ));
});

$app->run();