<?php

namespace OpenCoders\Podb\Provider\REST\v1;


use OpenCoders\Podb\REST\v1\json\AuditController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class AuditControllerProvider implements ControllerProviderInterface
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
        $app['rest.v1.json.audit_controller'] = $app->share(function ($app) {
            return new AuditController($app['audit.revision.manager']);
        });

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/audit', 'rest.v1.json.audit_controller:getList');
        $controllers->get('/audit/entity/{className}/{id}/revision', 'rest.v1.json.audit_controller:getEntityRevisions');
        $controllers->get('/audit/entity/{className}/{id}/revision/first', 'rest.v1.json.audit_controller:getFirstRevision');
        $controllers->get('/audit/entity/{className}/{id}/revision/current', 'rest.v1.json.audit_controller:getCurrentRevision');
        $controllers->get('/audit/entity/{className}/{id}/diff/{oldRevisionId}/{newRevisionId}', 'rest.v1.json.audit_controller:getDiff');

        return $controllers;
    }
}