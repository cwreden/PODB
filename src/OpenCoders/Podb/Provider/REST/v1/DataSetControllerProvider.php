<?php

namespace OpenCoders\Podb\Provider\REST\v1;


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
        $controllers = $app['controllers_factory'];

        $controllers->get('/dataSet', function () {
            throw new \Exception('Not implemented!');
        });

        return $controllers;
    }
}