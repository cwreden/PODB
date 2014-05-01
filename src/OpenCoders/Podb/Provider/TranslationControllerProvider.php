<?php

namespace OpenCoders\Podb\Provider;


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
        $controllers = $app['controllers_factory'];

        return $controllers;
    }
}