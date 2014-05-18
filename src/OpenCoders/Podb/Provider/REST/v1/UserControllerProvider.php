<?php

namespace OpenCoders\Podb\Provider\REST\v1;


use OpenCoders\Podb\REST\v1\json\UserController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class UserControllerProvider implements ControllerProviderInterface
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
        $app['rest.v1.json.user_controller'] = $app->share(function ($app) {
            return new UserController($app, $app['user'], $app['authentication']);
        });

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/user', 'rest.v1.json.user_controller:getList')->bind('rest.v1.json.user.list');
        $controllers->get('/user/{userName}', 'rest.v1.json.user_controller:get')->bind('rest.v1.json.user.get');
        $controllers->get('/user/{userName}/projects', 'rest.v1.json.user_controller:getProjects')->bind('rest.v1.json.user.project.list');
        $controllers->get('/user/{userName}/own/projects', 'rest.v1.json.user_controller:getOwnedProjects')
            ->bind('rest.v1.json.user.own.project.list');
        $controllers->get('/user/{userName}/languages', 'rest.v1.json.user_controller:getLanguages')->bind('rest.v1.json.user.language.list');
        $controllers->get('/user/{userName}/translations', 'rest.v1.json.user_controller:getTranslations')
            ->bind('rest.v1.json.user.translation.list');

        $controllers->post('/user/register', 'rest.v1.json.user_controller:register')->bind('rest.v1.json.user.register');
        $controllers->post('/user', 'rest.v1.json.user_controller:post')->bind('rest.v1.json.user.create');
        $controllers->put('/user/{id}', 'rest.v1.json.user_controller:put')->bind('rest.v1.json.user.update');
        $controllers->delete('/user/{id}', 'rest.v1.json.user_controller:delete')->bind('rest.v1.json.user.delete');

        return $controllers;
    }
}