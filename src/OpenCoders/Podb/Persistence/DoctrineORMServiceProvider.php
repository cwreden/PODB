<?php

namespace OpenCoders\Podb\Persistence;


use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * TODO extract as own repository and open source
 * Class DoctrineORMServiceProvider
 * @package OpenCoders\Podb\Persistence
 */
class DoctrineORMServiceProvider implements ServiceProviderInterface
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
        // @deprecated
        $app['entityManager'] = $app->share(function () use ($app) {
            return $app['orm'];
        });

        // TODO
        $app['orm.proxy.dir'] = __DIR__ . '/tmp/proxy';
        $app['orm.proxy.namespace'] = 'Doctrine\Entity\Proxies';
        $app['orm.entity.path'] = array(__DIR__ . '/Entity');

        $app['orm.configuration'] = $app->share(function ($pimple) {
            $configuration = new Configuration();

            $configuration->setProxyDir($pimple['orm.proxy.dir']);
            $configuration->setProxyNamespace($pimple['orm.proxy.namespace']);
            $configuration->setAutoGenerateProxyClasses($pimple['debug']);

            $driverImpl = $configuration->newDefaultAnnotationDriver($pimple['orm.entity.path']);
            $configuration->setMetadataDriverImpl($driverImpl);

            //            $cache = (self::$isDevMode ? new ArrayCache() : new ApcCache()); // @ToDo: How does the Array Cache and APC Cache works?
//            $config->setMetadataCacheImpl($cache);
//            $config->setQueryCacheImpl($cache);

            return $configuration;
        });

        $app['orm.event_manager'] = $app->share(function ($pimple) {
            return $pimple['db.event_manager'];
        });

        $app['orm'] = $app->share(function ($pimple) {
            return EntityManager::create(
                $pimple['db'],
                $pimple['orm.configuration'],
                $pimple['orm.event_manager']
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
        // TODO: Implement boot() method.
    }
}
