<?php

namespace OpenCoders\Podb\Provider\Service;


use OpenCoders\Podb\PODBServices;
use OpenCoders\Podb\Service\AuthenticationService;
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
        $app['authentication'] = $app->share(function ($app) {
            return new AuthenticationService($app['session'], $app[PODBServices::USER_REPOSITORY]);
        });
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
        // TODO: Implement boot() method.
    }
}