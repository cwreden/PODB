<?php

namespace OpenCoders\Podb\Security;

use OpenCoders\Podb\PODBServices;
use Silex\Application;
use Silex\Provider\SecurityServiceProvider;
use Silex\ServiceProviderInterface;

class PODBSecurityServiceProvider implements ServiceProviderInterface
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
        $app[SecurityServices::SALT_GENERATOR] = $app->share(function () {
            return new PasswordSaltGenerator();
        });

        $app[SecurityServices::USER_PROVIDER] = $app->share(function ($pimple) {
            return new UserProvider($pimple[PODBServices::USER_REPOSITORY]);
        });

        $app['security.firewalls'] = array(
            'api' => array(
//                'anonymous' => true,
                'pattern' => '^/api',
                'security' => true, //!$app['debug'],
                'http' => true,
                'users' => $app->share(function ($pimple) {
                    return $pimple[SecurityServices::USER_PROVIDER];
                }),
            ),
        );

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
