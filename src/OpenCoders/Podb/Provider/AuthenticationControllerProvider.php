<?php

namespace OpenCoders\Podb\Provider;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class AuthenticationControllerProvider implements ControllerProviderInterface
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
        $controllers = $app['controllers_factory'];

        /**
         * @Debug
         */
        $controllers->get('/lock', function () use ($app) {
            $app['session']->set('locked', true);
            return true;
        });

        /**
         * @Debug
         */
        $controllers->get('/unlock', function () use ($app) {
            $app['session']->set('locked', false);
            return true;
        });

        return $controllers;
    }
}