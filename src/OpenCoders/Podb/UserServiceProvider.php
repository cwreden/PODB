<?php

namespace OpenCoders\Podb;

use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Persistence\Entity\User;
use Silex\Application;
use Silex\ServiceProviderInterface;

class UserServiceProvider implements ServiceProviderInterface
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
        $app[PODBServices::USER_REPOSITORY] = $app->share(function ($pimple) {
            /** @var EntityManager $orm */
            $orm = $pimple['orm'];
            return $orm->getRepository(User::ENTITY_NAME);
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
