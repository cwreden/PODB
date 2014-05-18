<?php

namespace OpenCoders\Podb\Provider\REST\v1;


use OpenCoders\Podb\REST\v1\json\DataSetController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class DataSetControllerProvider implements ControllerProviderInterface
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
        $app['rest.v1.json.dataSet_controller'] = $app->share(function ($app) {
            return new DataSetController($app, $app['dataSet'], $app['authentication']);
        });

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/dataSet', 'rest.v1.json.dataSet_controller:getList')->bind('rest.v1.json.dataSet.getList');
        $controllers->get('/dataSet/{id}', 'rest.v1.json.dataSet_controller:get')->bind('rest.v1.json.dataSet.get');

        $controllers->post('/dataSet', 'rest.v1.json.dataSet_controller:post')->bind('rest.v1.json.dataSet.create');
        $controllers->put('/dataSet/{id}', 'rest.v1.json.dataSet_controller:put')->bind('rest.v1.json.dataSet.update');
        $controllers->delete('/dataSet/{id}', 'rest.v1.json.dataSet_controller:delete')->bind('rest.v1.json.dataSet.delete');

        return $controllers;
    }
}