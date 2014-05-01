<?php

namespace OpenCoders\Podb\Provider;


use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestRateLimitServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        // TODO: Implement register() method.
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        $app->before(function () use ($app) {
//            var_dump($app['session']->get('rateCounter'));
        });

        $app->after(function (Request $request, Response $response) use ($app) {
            $session = $app['session'];
            $counter = (int) $session->get('rateCounter');

            if (!is_int($counter)) {
                $counter = 0;
            }
            $counter++;

            $session->set('rateCounter', $counter);
            $response->headers->add(array('rateCounter' => $counter));
        });
    }
}