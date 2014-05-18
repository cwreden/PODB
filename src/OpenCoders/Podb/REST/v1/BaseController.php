<?php

namespace OpenCoders\Podb\REST\v1;


use Silex\Application;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Class BaseController
 * @package OpenCoders\Podb\REST\v1
 */
abstract class BaseController
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
     * @deprecated
     *
     * @throws HttpException
     * @return bool
     */
    protected function ensureSession()
    {
        if (!$this->app['session']->get('authenticated')) {
            throw new HttpException(401, 'Authentication required!');
        }
    }

    /**
     * @deprecated direkt dem kontroller übergeben, wenn überhaupt.
     * @return UrlGenerator
     */
    protected function getUrlGenerator()
    {
        return $this->app['url_generator'];
    }
}