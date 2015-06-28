<?php

namespace OpenCoders\Podb\Provider\Service;


use OpenCoders\Podb\Configuration\ConfigurationService;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * TODO refactor
 * @deprecated
 * Class ConfigurationServiceProvider
 * @package OpenCoders\Podb\Provider\Service
 */
class ConfigurationServiceProvider implements ServiceProviderInterface
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
        $app['configuration'] = $app->share(function () {
            return new ConfigurationService();
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