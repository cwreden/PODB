<?php

namespace OpenCoders\Podb;


use OpenCoders\Podb\Api\ResourceControllerProvider;
use OpenCoders\Podb\Persistence\AuditServiceProvider;
use OpenCoders\Podb\Persistence\DoctrineORMServiceProvider;
use OpenCoders\Podb\Provider\ACLServiceProvider;
use OpenCoders\Podb\Provider\IndexControllerProvider;
use OpenCoders\Podb\Provider\Service\AuthenticationServiceProvider;
use OpenCoders\Podb\Provider\Service\CategoryServiceProvider;
use OpenCoders\Podb\Provider\Service\ConfigurationServiceProvider;
use OpenCoders\Podb\Provider\Service\DataSetServiceProvider;
use OpenCoders\Podb\Provider\Service\ErrorHandlerServiceProvider;
use OpenCoders\Podb\Provider\Service\LanguageServiceProvider;
use OpenCoders\Podb\Provider\Service\ProjectServiceProvider;
use OpenCoders\Podb\Provider\Service\RequestRateLimitServiceProvider;
use OpenCoders\Podb\Provider\Service\TranslationServiceProvider;
use OpenCoders\Podb\Provider\Service\UserServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class Application extends \Silex\Application
{
    /**
     * @param array $values
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        // Silex Provider
        $this->register(new SessionServiceProvider());
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new UrlGeneratorServiceProvider());

//        $this->register(new SwiftmailerServiceProvider()
// TODO config auslagern in eine Konfigurationsdatei.
//    ,
//    array(
//        'swiftmailer.options' => array(
//            'host' => 'localhost',
//            'port' => '25',
//            'username' => 'username',
//            'password' => 'password',
//            'encryption' => null,
//            'auth_mode' => null
//        )
//    )
//        );
        $this->register(new DoctrineServiceProvider());// TODO configuration
        $this->register(
            new TwigServiceProvider(),
            array(
                'twig.path' => APPLICATION_ROOT . '/src/Views',
                'twig.options' => array('cache' => APPLICATION_ROOT . '/data/twig'),
            )
        );
        $this->register(
            new MonologServiceProvider(),
            array(
                'monolog.logfile' => APPLICATION_ROOT . "/data/application.log"
            )
        );

        // Service Provider
        $this->register(new DoctrineORMServiceProvider());
        $this->register(new AuditServiceProvider());
        $this->register(new ConfigurationServiceProvider());

        $this->register(new UserServiceProvider());
        $this->register(new ProjectServiceProvider());
        $this->register(new LanguageServiceProvider());
        $this->register(new CategoryServiceProvider());
        $this->register(new DataSetServiceProvider());
        $this->register(new TranslationServiceProvider());

        $this->register(new ACLServiceProvider());
        $this->register(new AuthenticationServiceProvider());

        $this->register(new RequestRateLimitServiceProvider());
        $this->register(new ErrorHandlerServiceProvider());

        // Page
        $this->mount('', new IndexControllerProvider());
        // TODO login page
        // TODO register page
        // TODO profile page
        // TODO project page
        // TODO ...

        // REST
        $this->mount('api/resource', new ResourceControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\UserControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\ProjectControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\LanguageControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\TranslationControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\AuditControllerProvider());
//        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\ACLControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\AuthenticationControllerProvider());
        // TODO version concept

        /**
         * Put payload to request part
         * TODO extract in service
         */
        $this->before(function (Request $request) {
            if ($request->getContentType() === 'json') {
                $request->request->add(json_decode($request->getContent(), true));
            }
        });

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }
    }
}
