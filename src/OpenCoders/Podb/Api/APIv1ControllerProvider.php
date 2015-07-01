<?php

namespace OpenCoders\Podb\Api;


use OpenCoders\Podb\PODBServices;
use OpenCoders\Podb\REST\v1\json\AuditController;
use OpenCoders\Podb\REST\v1\json\AuthenticationController;
use OpenCoders\Podb\REST\v1\json\ProjectController;
use OpenCoders\Podb\REST\v1\json\TranslationController;
use OpenCoders\Podb\Security\SecurityServices;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class APIv1ControllerProvider implements ControllerProviderInterface
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
        $app[APIServices::V1_USER_CONTROLLER] = $app->share(function ($pimple) {
            return new APIv1UserController(
                $pimple[PODBServices::USER_REPOSITORY],
                $pimple['authentication'],
                $pimple['url_generator'],
                $pimple['orm'],
                $pimple['security.encoder.digest'],
                $pimple[SecurityServices::SALT_GENERATOR]
            );
        });

        $app[APIServices::V1_PROJECT_CONTROLLER] = $app->share(function ($app) {
            return new ProjectController($app, $app[PODBServices::PROJECT_REPOSITORY], $app['authentication']);
        });

        $app[APIServices::V1_LANGUAGE_CONTROLLER] = $app->share(function ($app) {
            return new APIv1LanguageController(
                $app[PODBServices::LANGUAGE_REPOSITORY],
                $app['authentication']
            );
        });

        $app[APIServices::V1_TRANSLATION_CONTROLLER] = $app->share(function ($app) {
            return new TranslationController($app, $app[PODBServices::TRANSLATION_REPOSITORY], $app['authentication']);
        });

        $app[APIServices::V1_AUDIT_CONTROLLER] = $app->share(function ($app) {
            return new AuditController($app['audit.revision.manager']);
        });

        $app[APIServices::V1_AUTHENTICATION_CONTROLLER] = $app->share(function ($app) {
            return new AuthenticationController($app, $app['authentication'], $app['security.token_storage']);
        });


        /** @var ControllerCollection $collection */
        $collection = $app[PODBServices::CONTROLLER_FACTORY];


        $collection->get('/user', APIServices::V1_USER_CONTROLLER . ':getList')
            ->bind(ApiURIs::V1_USER_LIST);
        $collection->get('/user/{userName}', APIServices::V1_USER_CONTROLLER . ':get')
            ->bind(ApiURIs::V1_USER_GET);
        $collection->get('/user/{userName}/projects', APIServices::V1_USER_CONTROLLER . ':getProjects')
            ->bind(ApiURIs::V1_USER_PROJECT_LIST);
        $collection->get('/user/{userName}/own/projects', APIServices::V1_USER_CONTROLLER . ':getOwnedProjects')
            ->bind(ApiURIs::V1_USER_PROJECT_OWN_LIST);
        $collection->get('/user/{userName}/languages', APIServices::V1_USER_CONTROLLER . ':getLanguages')
            ->bind(ApiURIs::V1_USER_LANGUAGE_LIST);
        $collection->get('/user/{userName}/translations', APIServices::V1_USER_CONTROLLER . ':getTranslations')
            ->bind(ApiURIs::V1_USER_TRANSLATION_LIST);

        $collection->post('/user/register', APIServices::V1_USER_CONTROLLER . ':register')
            ->bind(ApiURIs::V1_USER_REGISTER);
        $collection->post('/user', APIServices::V1_USER_CONTROLLER . ':post')
            ->bind(ApiURIs::V1_USER_CREATE);
        $collection->put('/user/{id}', APIServices::V1_USER_CONTROLLER . ':put')
            ->bind(ApiURIs::V1_USER_UPDATE);
        $collection->delete('/user/{id}', APIServices::V1_USER_CONTROLLER . ':delete')
            ->bind(ApiURIs::V1_USER_DELETE);


        $collection->get('/project', APIServices::V1_PROJECT_CONTROLLER . ':getList')
            ->bind(ApiURIs::V1_PROJECT_LIST);
        $collection->get('/project/{projectName}', APIServices::V1_PROJECT_CONTROLLER . ':get')
            ->bind(ApiURIs::V1_PROJECT_GET);
        $collection->get('/project/{projectName}/contributors', APIServices::V1_PROJECT_CONTROLLER . ':getContributors')
            ->bind(ApiURIs::V1_PROJECT_CONTRIBUTOR_LIST);
//        $collection->get('/project/{projectName}/categories', APIServices::V1_PROJECT_CONTROLLER . ':getCategories')
//            ->bind('rest.v1.json.project.category.list');
        $collection->get('/project/{projectName}/languages', APIServices::V1_PROJECT_CONTROLLER . ':getLanguages')
            ->bind(ApiURIs::V1_PROJECT_LANGUAGE_LIST);

        $collection->post('/project', APIServices::V1_PROJECT_CONTROLLER . ':post')
            ->bind(ApiURIs::V1_PROJECT_CREATE);
        $collection->put('/project/{id}', APIServices::V1_PROJECT_CONTROLLER . ':put')
            ->bind(ApiURIs::V1_PROJECT_UPDATE);
        $collection->delete('/project/{id}', APIServices::V1_PROJECT_CONTROLLER . ':delete')
            ->bind(ApiURIs::V1_PROJECT_DELETE);


        $collection->get('/language', APIServices::V1_LANGUAGE_CONTROLLER . ':getList')
            ->bind(ApiURIs::V1_LANGUAGE_LIST);
        $collection->get('/language/{locale}', APIServices::V1_LANGUAGE_CONTROLLER . ':get')
            ->bind(ApiURIs::V1_LANGUAGE_GET);
        $collection->get('/language/{locale}/supporter', APIServices::V1_LANGUAGE_CONTROLLER . ':getSupporters')
            ->bind(ApiURIs::V1_LANGUAGE_SUPPORTER_LIST);

        $collection->post('/language', APIServices::V1_LANGUAGE_CONTROLLER . ':post')
            ->bind(ApiURIs::V1_LANGUAGE_CREATE);
        $collection->put('/language/{id}', APIServices::V1_LANGUAGE_CONTROLLER . ':put')
            ->bind(ApiURIs::V1_LANGUAGE_UPDATE);
        $collection->delete('/language/{id}', APIServices::V1_LANGUAGE_CONTROLLER . ':delete')
            ->bind(ApiURIs::V1_LANGUAGE_DELETE);


//        $collection->get('/translation', APIServices::V1_TRANSLATION_CONTROLLER . ':getList')->bind('rest.v1.json.translation.list');
//        $collection->get('/translation/{id}', APIServices::V1_TRANSLATION_CONTROLLER . ':get')->bind('rest.v1.json.translation.get');
//
//        $collection->post('/translation', APIServices::V1_TRANSLATION_CONTROLLER . ':post')->bind('rest.v1.json.translation.create');
//        $collection->put('/translation/{id}', APIServices::V1_TRANSLATION_CONTROLLER . ':put')->bind('rest.v1.json.translation.update');
//        $collection->delete('/translation/{id}', APIServices::V1_TRANSLATION_CONTROLLER . ':delete')->bind('rest.v1.json.translation.delete');
//
//
//        $collection->get('/audit', APIServices::V1_AUDIT_CONTROLLER . ':getList');
//        $collection->get('/audit/entity/{className}/{id}/revision', APIServices::V1_AUDIT_CONTROLLER . ':getEntityRevisions');
//        $collection->get('/audit/entity/{className}/{id}/revision/first', APIServices::V1_AUDIT_CONTROLLER . ':getFirstRevision');
//        $collection->get('/audit/entity/{className}/{id}/revision/current', APIServices::V1_AUDIT_CONTROLLER . ':getCurrentRevision');
//        $collection->get('/audit/entity/{className}/{id}/diff/{oldRevisionId}/{newRevisionId}', APIServices::V1_AUDIT_CONTROLLER . ':getDiff');
//
//
//        $collection->post('/authentication/login', APIServices::V1_AUTHENTICATION_CONTROLLER . ':login')
//            ->bind('rest.v1.json.authentication.login');
//        $collection->post('/authentication/logout', APIServices::V1_AUTHENTICATION_CONTROLLER . ':logout')
//            ->bind('rest.v1.json.authentication.logout');
//        $collection->get('/authentication/isLoggedIn', APIServices::V1_AUTHENTICATION_CONTROLLER . ':isLoggedIn')
//            ->bind('rest.v1.json.authentication.isLoggedIn');
//
//        $collection->get('/authentication/lock', APIServices::V1_AUTHENTICATION_CONTROLLER . ':lock')
//            ->bind(APIServices::V1_AUTHENTICATION_CONTROLLER . ':lock');
//        $collection->get('/authentication/unlock', APIServices::V1_AUTHENTICATION_CONTROLLER . ':unlock')
//            ->bind(APIServices::V1_AUTHENTICATION_CONTROLLER . ':unlock');

        return $collection;
    }
}
