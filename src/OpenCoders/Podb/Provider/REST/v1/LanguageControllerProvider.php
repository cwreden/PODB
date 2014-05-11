<?php

namespace OpenCoders\Podb\Provider\REST\v1;


use OpenCoders\Podb\REST\v1\json\LanguageController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class LanguageControllerProvider implements ControllerProviderInterface
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
        $app['rest.v1.json.language_controller'] = $app->share(function ($app) {
            return new LanguageController($app, $app['language'], $app['authentication']);
        });

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/language', 'rest.v1.json.language_controller:getList')->bind('rest.v1.json.language.list');
        $controllers->get('/language/{locale}', 'rest.v1.json.language_controller:get')->bind('rest.v1.json.language.get');
        $controllers->get('/language/{locale}/supporter', 'rest.v1.json.language_controller:getSupporters')
            ->bind('rest.v1.json.language.supporter.list');

        $controllers->post('/language', 'rest.v1.json.language_controller:post')->bind('rest.v1.json.language.create');
        $controllers->put('/language/{id}', 'rest.v1.json.language_controller:put')->bind('rest.v1.json.language.update');
        $controllers->delete('/language/{id}', 'rest.v1.json.language_controller:delete')->bind('rest.v1.json.language.delete');

        return $controllers;
    }
}