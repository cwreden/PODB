<?php

namespace OpenCoders\Podb\Provider\REST\v1;


use OpenCoders\Podb\REST\v1\json\CategoryController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class CategoryControllerProvider implements ControllerProviderInterface
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
        $app['rest.v1.json.category_controller'] = $app->share(function ($app) {
            return new CategoryController($app, $app['category'], $app['authentication']);
        });

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/category', 'rest.v1.json.category_controller:getList')->bind('rest.v1.json.category.list');
        $controllers->get('/category/{id}', 'rest.v1.json.category_controller:get')->bind('rest.v1.json.category.get');
        $controllers->get('/category/{id}/dataSet', 'rest.v1.json.category_controller:getDataSets')->bind('rest.v1.json.category.dataSet.list');

        $controllers->post('/category', 'rest.v1.json.category_controller:post')->bind('rest.v1.json.category.create');
        $controllers->put('/category/{id}', 'rest.v1.json.category_controller:put')->bind('rest.v1.json.category.update');
        $controllers->delete('/category/{id}', 'rest.v1.json.category_controller:delete')->bind('rest.v1.json.category.delete');

        return $controllers;
    }
}