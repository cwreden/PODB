<?php

namespace OpenCoders\Podb\REST\v1;


use Silex\Application;
use Symfony\Component\Routing\Generator\UrlGenerator;

class BaseController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var string
     * @deprecated
     */
    protected $apiVersion = 'v1';

    function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Returns true, if $value is an integer
     *
     * @param $value
     * @return bool
     */
    protected function isId($value)
    {
        return isset($value) && intval($value) != 0;
    }

    /**
     * Verified user login, throw exception if not logged in.
     *
     * TODO implement
     *
     * @return bool
     */
    protected function ensureSession()
    {
//        $session = $this->app['session'];
        return true;
    }

    /**
     * @return UrlGenerator
     */
    protected function getUrlGenerator()
    {
        return $this->app['url_generator'];
    }
} 