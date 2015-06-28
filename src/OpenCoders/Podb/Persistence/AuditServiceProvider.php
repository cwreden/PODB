<?php

namespace OpenCoders\Podb\Persistence;


use OpenCoders\Podb\Service\AuditService;
use Silex\Application;
use Silex\ServiceProviderInterface;
use SimpleThings\EntityAudit\AuditConfiguration;
use SimpleThings\EntityAudit\AuditManager;

class AuditServiceProvider implements ServiceProviderInterface
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
        // TODO refactor
        $app['audit'] = $app->share(function ($app) {
            return new AuditService($app['audit.reader']);
        });

        $app['audit.option.entityClasses'] = array(
            'OpenCoders\Podb\Persistence\Entity\User',
            'OpenCoders\Podb\Persistence\Entity\Credential',
            'OpenCoders\Podb\Persistence\Entity\Language',
            'OpenCoders\Podb\Persistence\Entity\Project',
            'OpenCoders\Podb\Persistence\Entity\Domain',
            'OpenCoders\Podb\Persistence\Entity\Message',
            'OpenCoders\Podb\Persistence\Entity\Translation',
        );

        $app['audit.configuration'] = $app->share(function ($pimple) {
            $auditConfiguration = new AuditConfiguration();
            $auditConfiguration->setAuditedEntityClasses($pimple['audit.option.entityClasses']);
            return $auditConfiguration;
        });

        $app['audit.manager'] = $app->share(function ($pimple) {
            $auditManager = new AuditManager($pimple['audit.configuration']);
            $auditManager->registerEvents($pimple['orm.event_manager']);
            return $auditManager;
        });
        $app['audit.reader'] = function ($pimple) {
            /** @var AuditManager $auditManager */
            $auditManager = $pimple['audit.manager'];
            return $auditManager->createAuditReader($pimple['orm']);
        };
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
