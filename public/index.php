<?php

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
 * @Debug
 */
$app->get('/', function () use ($app) {
    if ($app['session']->get('locked') === true) {
        return include('pages/examples/lockscreen.html');
    }
    return include('index.html');
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
    return $app['twig']->render('test.twig', array('testValue' => 'trolllo'));
});

/**
 * Test implementation
 */
$app->post('/login', function () use ($app) {
    sleep(3);

    return new Symfony\Component\HttpFoundation\JsonResponse(array(
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