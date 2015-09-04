<?php

namespace OpenCoders\Podb;

use Exception;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorHandlerServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        // TODO: Weiter ausbauen so das Fehler genauer und dynamisch behandelt werden können.
        $app->error(function (Exception $e, $code) use ($app) {
            $errorData = array(
                'errorClass' => get_class($e),
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            );

            if ($e->getPrevious() !== null) {
                $errorData['errorSubClass'] = get_class($e->getPrevious());
            }
            if ($e->getCode() !== 0) {
                $code = $e->getCode();
            }
            if ($app['debug'] === true) {
                $errorData['errorFile'] = $e->getFile();
                $errorData['errorLine'] = $e->getLine();
            }

            return new JsonResponse($errorData, $code);
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
