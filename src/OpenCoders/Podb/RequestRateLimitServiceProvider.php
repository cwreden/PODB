<?php

namespace OpenCoders\Podb;


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
 * TODO optimize exception
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
        // TODO: Implement register() method.
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
        // TODO only at api calls
        $app->before(function (Request $request) use ($app) {
            $session = $request->getSession();

            $limit = $app['podb.requestLimit.limit'];
            if ($session->get('authenticated') === true) {
                $limit = $app['podb.requestLimit.authenticatedLimit'];
            }
            if ($limit == 0) {
                return;
            }

            $rate = $session->get('rateLimit');

            $resetInterval = $app['podb.requestLimit.resetInterval'];
            if (!isset($rate)) {
                $rate = array('reset_at' => (time() + $resetInterval), 'used' => 0);
                $session->set('rateLimit', $rate);
            }

            $actualTime = time();
            if (isset($rate['reset_at']) && $rate['reset_at'] - $actualTime <= 0) {
                $rate['reset_at'] = ($actualTime + $resetInterval);
                $rate['used'] = 0;
                $session->set('rateLimit', $rate);
            }

            $remaining = $limit - $rate['used'];
            if ($remaining < 0) {
                $remaining = 0;
            }

            if ($rate['used'] >= $limit) {
                $app->abort(403, 'Max rate limit exceeded!', array(
                    'X-RateLimit-Limit' => $limit,
                    'X-RateLimit-Remaining' => $remaining,
                    'X-RateLimit-Reset' => $rate['reset_at'],
                ));
            }
        });

        $app->after(function (Request $request, Response $response) use ($app) {
            $session = $request->getSession();
            $rate = $session->get('rateLimit');

            $rate['used']++;
            $session->set('rateLimit', $rate);

            $limit = $app['podb.requestLimit.limit'];
            if ($session->get('authenticated') === true) {
                $limit = $app['podb.requestLimit.authenticatedLimit'];
            }
            if ($limit == 0) {
                return;
            }

            $remaining = $limit - $rate['used'];
            if ($remaining < 0) {
                $remaining = 0;
            }

            $response->headers->add(array(
                'X-RateLimit-Limit' => $limit,
                'X-RateLimit-Remaining' => $remaining,
                'X-RateLimit-Reset' => $rate['reset_at'],
            ));
        });
    }
}