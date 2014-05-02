<?php

namespace OpenCoders\Podb\Provider\REST\v1;


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
        $controllers->get('/auth/lock', function () use ($app) {
            $app['session']->set('locked', true);
            return true;
        });

        /**
         * @Debug
         */
        $controllers->get('/auth/unlock', function () use ($app) {
            $app['session']->set('locked', false);
            return true;
        });

        return $controllers;
    }
}