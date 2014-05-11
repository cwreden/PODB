<?php

namespace OpenCoders\Podb\Provider\Service;


use OpenCoders\Podb\Service\TranslationService;
use Silex\Application;
use Silex\ServiceProviderInterface;

class TranslationServiceProvider implements ServiceProviderInterface
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
        $app['translation'] = $app->share(function ($app) {
            return new TranslationService($app['entityManager']);
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