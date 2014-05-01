<?php

namespace OpenCoders\Podb\Provider;


use Silex\Application;
use Silex\ServiceProviderInterface;

class AuthenticationServiceProvider implements ServiceProviderInterface
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

    }
}