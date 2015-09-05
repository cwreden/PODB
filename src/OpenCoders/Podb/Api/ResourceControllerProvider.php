<?php

namespace OpenCoders\Podb\Api;

use OpenCoders\Podb\PODBServices;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class ResourceControllerProvider implements ControllerProviderInterface
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
        /** @var ControllerCollection $collection */
        $collection = $app[PODBServices::CONTROLLER_FACTORY];

        $collection->get('/resource', function (Request $request) use ($app) {

            $requestUri = $request->getRequestUri();
            $pattern = '#^' . substr($request->getRequestUri(), 0, strpos($requestUri, '/resource')) . '#';

            /** @var RouteCollection $routes */
            $routes = $app['routes'];
            $resources = array();
            foreach ($routes->all() as $route) {
                if (preg_match($pattern, $route->getPath())) {
                    $resources[] = array(
                        'path' => $route->getPath(),
                        'methods' => $route->getMethods(),
                    );
                }
            }

            return new JsonResponse($resources);
        });

        return $collection;
    }
}
