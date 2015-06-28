<?php

namespace OpenCoders\Podb\Api;


use OpenCoders\Podb\PODBServices;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        $collection->get('/', function () use ($app) {
            $resources = array(
                '/rest/v1/user'
            );

            return new JsonResponse($resources);
        });

        return $collection;
    }
}
