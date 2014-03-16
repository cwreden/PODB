<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\SessionServiceProvider());

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