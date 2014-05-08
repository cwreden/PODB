<?php

namespace OpenCoders\Podb\Provider\REST\v1;


use OpenCoders\Podb\REST\v1\json\AuthenticationController;
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
        $app['rest.v1.json.authentication_controller'] = $app->share(function ($app) {
            return new AuthenticationController($app, $app['authentication']);
        });

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->post('/authentication/login', 'rest.v1.json.authentication_controller:login')
            ->bind('rest.v1.json.authentication.login');
        $controllers->post('/authentication/logout', 'rest.v1.json.authentication_controller:logout')
            ->bind('rest.v1.json.authentication.logout');
        $controllers->get('/authentication/isLoggedIn', 'rest.v1.json.authentication_controller:isLoggedIn')
            ->bind('rest.v1.json.authentication.isLoggedIn');

        $controllers->get('/authentication/lock', 'rest.v1.json.authentication_controller:lock')
            ->bind('rest.v1.json.authentication_controller:lock');
        $controllers->get('/authentication/unlock', 'rest.v1.json.authentication_controller:unlock')
            ->bind('rest.v1.json.authentication_controller:unlock');


        return $controllers;
    }
}