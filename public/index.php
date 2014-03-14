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
        'twig.options' => array('cache' => APPLICATION_ROOT . '/data/twig'),// TODO
    )
);

$app->register(
    new \Silex\Provider\MonologServiceProvider(),
    array(
        'monolog.logfile' => APPLICATION_ROOT . "/data/application.log" // TODO
    )
);



$app->get('/', function () use ($app) {
    if ($app['session']->get('locked') === true) {
        return include('pages/examples/lockscreen.html');
    }
    return include('index.html');
});

$app->get('/lock', function () use ($app) {
    $app['session']->set('locked', true);
    return true;
});

$app->get('/unlock', function () use ($app) {
    $app['session']->set('locked', false);
    return true;
});

$app->run();