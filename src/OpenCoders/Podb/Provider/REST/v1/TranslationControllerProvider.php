<?php

namespace OpenCoders\Podb\Provider\REST\v1;


use OpenCoders\Podb\PODBServices;
use OpenCoders\Podb\REST\v1\json\TranslationController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class TranslationControllerProvider implements ControllerProviderInterface
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
        $app['rest.v1.json.translation_controller'] = $app->share(function ($app) {
            return new TranslationController($app, $app[PODBServices::TRANSLATION_REPOSITORY], $app['authentication']);
        });

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/translation', 'rest.v1.json.translation_controller:getList')->bind('rest.v1.json.translation.list');
        $controllers->get('/translation/{id}', 'rest.v1.json.translation_controller:get')->bind('rest.v1.json.translation.get');

        $controllers->post('/translation', 'rest.v1.json.translation_controller:post')->bind('rest.v1.json.translation.create');
        $controllers->put('/translation/{id}', 'rest.v1.json.translation_controller:put')->bind('rest.v1.json.translation.update');
        $controllers->delete('/translation/{id}', 'rest.v1.json.translation_controller:delete')->bind('rest.v1.json.translation.delete');

        return $controllers;
    }
}