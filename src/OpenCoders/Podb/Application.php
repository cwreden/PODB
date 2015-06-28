<?php

namespace OpenCoders\Podb;


use OpenCoders\Podb\Api\ResourceControllerProvider;
use OpenCoders\Podb\Persistence\AuditServiceProvider;
use OpenCoders\Podb\Persistence\DoctrineORMServiceProvider;
use OpenCoders\Podb\Provider\ACLServiceProvider;
use OpenCoders\Podb\Provider\IndexControllerProvider;
use OpenCoders\Podb\Provider\Service\AuthenticationServiceProvider;
use OpenCoders\Podb\Provider\Service\CategoryServiceProvider;
use OpenCoders\Podb\Provider\Service\DataSetServiceProvider;
use OpenCoders\Podb\Provider\Service\ErrorHandlerServiceProvider;
use OpenCoders\Podb\Provider\Service\LanguageServiceProvider;
use OpenCoders\Podb\Provider\Service\ProjectServiceProvider;
use OpenCoders\Podb\Provider\Service\RequestRateLimitServiceProvider;
use OpenCoders\Podb\Provider\Service\TranslationServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

class Application extends \Silex\Application
{
    /**
     * @param array $values
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        // Silex provider
        $this->register(new SessionServiceProvider());
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new UrlGeneratorServiceProvider());

        $this->register(new SwiftmailerServiceProvider());
        $this->register(new DoctrineServiceProvider());
        $this->register(new TwigServiceProvider());
        $this->register(new MonologServiceProvider());

        // Potential third party service provider
        $this->register(new DoctrineORMServiceProvider());
        $this->register(new AuditServiceProvider());
        $this->register(new RequestRateLimitServiceProvider());
        $this->register(new RequestJsonFormatServiceProvider());


        // Service provider
        $this->register(new UserServiceProvider());
        $this->register(new ProjectServiceProvider());
        $this->register(new LanguageServiceProvider());
        $this->register(new CategoryServiceProvider());
        $this->register(new DataSetServiceProvider());
        $this->register(new TranslationServiceProvider());

        $this->register(new ACLServiceProvider());
        $this->register(new AuthenticationServiceProvider());

        $this->register(new ErrorHandlerServiceProvider());

        // Page controller
        $this->mount('', new IndexControllerProvider());
        // TODO login page
        // TODO register page
        // TODO profile page
        // TODO project page
        // TODO ...

        // API controller
        $this->mount('api/resource', new ResourceControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\UserControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\ProjectControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\LanguageControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\TranslationControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\AuditControllerProvider());
//        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\ACLControllerProvider());
        $this->mount('/rest/v1', new \OpenCoders\Podb\Provider\REST\v1\AuthenticationControllerProvider());
        // TODO version concept

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }
    }
}
