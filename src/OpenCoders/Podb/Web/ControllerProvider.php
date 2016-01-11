<?php

namespace OpenCoders\Podb\Web;

use OpenCoders\Podb\PODBServices;
use OpenCoders\Podb\Security\SecurityServices;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ControllerProvider implements ControllerProviderInterface
{
    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $app[Controllers::INDEX] = $app->share(function ($p) {
            return new IndexController(
                $p['twig'],
                $p[PODBServices::MANAGER]
            );
        });

        $app[Controllers::INSTALL] = $app->share(function ($p) {
            return new InstallController(
                $p['orm'],
                $p['security.encoder.digest'],
                $p[SecurityServices::SALT_GENERATOR]
            );
        });

        $controllers = $app['controllers_factory'];

        $controllers->get('/', Controllers::INDEX . ':index');
        $controllers->get('/install', Controllers::INSTALL . ':installAction');

        return $controllers;
    }
}
