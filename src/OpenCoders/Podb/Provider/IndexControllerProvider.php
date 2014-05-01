<?php

namespace OpenCoders\Podb\Provider;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexControllerProvider implements ControllerProviderInterface
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
         * Debug
         */
        $controllers->get('/', function () use ($app) {
            $app['session']->start();
            if (isset($_SESSION['attributes']) && isset($_SESSION['attributes']['locked']) && $_SESSION['attributes']['locked'] === true || $app['session']->get('locked')) {
                return $app['twig']->render('lockscreen.html');
            }
            return $app['twig']->render('base.html');
        });


        /**
         * Debug
         */
        $controllers->get('/menu', function () use ($app) {
            return new JsonResponse(array(
                array(
                    'title' => 'Dashboard',
                    'fa' => 'fa-dashboard',
                    'route' => '#/dashboard'
                ),
                array(
                    'title' => 'Dashboard',
                    'fa' => 'fa-dashboard',
                    'sub-menu' => array(
                        array(
                            'title' => 'Dashboard',
                            'fa' => 'fa-dashboard',
                            'route' => '#/dashboard'
                        )
                    )
                )
            ));
        });

        return $controllers;
    }
}