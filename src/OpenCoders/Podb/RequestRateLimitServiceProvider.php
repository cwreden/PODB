<?php

namespace OpenCoders\Podb;


use OpenCoders\Podb\Security\RateLimiter;
use OpenCoders\Podb\Security\RateLimitException;
use OpenCoders\Podb\Security\SecurityServices;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RequestRateLimitServiceProvider
 * @package OpenCoders\Podb\Provider
 *
 * TODO check logged in state
 * TODO exclude routes or check only selected routes
 */
class RequestRateLimitServiceProvider implements ServiceProviderInterface
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
        $app[SecurityServices::RATE_LIMITER] = $app->share(function ($pimple) {
            return new RateLimiter(
                $pimple[SecurityServices::RATE_LIMIT_REQUEST_LIMIT],
                $pimple[SecurityServices::RATE_LIMIT_AUTHENTICATED_REQUEST_LIMIT],
                $pimple[SecurityServices::RATE_LIMIT_REQUEST_LIMIT_RESET_INTERVAL],
                $pimple['session']
            );
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // TODO only at api calls
        $app->before(function (Request $request) use ($app) {
            $pathInfo = $request->getPathInfo();
            if (strpos($pathInfo, '/api') !== 0) {
                return;
            }

            /** @var RateLimiter $rateLimiter */
            $rateLimiter = $app[SecurityServices::RATE_LIMITER];

            try {
                $rateLimiter->increaseUsed();
            } catch (RateLimitException $e) {
                $app->abort(403, $e->getMessage(), array(
                    'X-RateLimit-Limit' => $rateLimiter->getLimit(),
                    'X-RateLimit-Remaining' => $rateLimiter->getRemaining(),
                    'X-RateLimit-Reset' => $rateLimiter->getResetAt(),
                ));
            }

        }, 128);

        $app->after(function (Request $request, Response $response) use ($app) {
            $pathInfo = $request->getPathInfo();
            if (strpos($pathInfo, '/api') === 0) {
                return;
            }

            /** @var RateLimiter $rateLimiter */
            $rateLimiter = $app[SecurityServices::RATE_LIMITER];

            $response->headers->add(array(
                'X-RateLimit-Limit' => $rateLimiter->getLimit(),
                'X-RateLimit-Remaining' => $rateLimiter->getRemaining(),
                'X-RateLimit-Reset' => $rateLimiter->getResetAt(),
            ));
        }, Application::LATE_EVENT);
    }
}