<?php

namespace OpenCoders\Podb;


use Silex\Application;
use Silex\ServiceProviderInterface;

class PODBServiceProvider implements ServiceProviderInterface
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
        $app[Configurations::NAME] = 'PODB';

        $app[PODBServices::MANAGER] = $app->share(function ($p) {
            return new Manager(
                $p[Configurations::NAME]
            );
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
