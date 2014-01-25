<?php

namespace OpenCoders\Podb\Persistence\Entity;

use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Session\Session;
use OpenCoders\Podb\Session\SessionManager;

abstract class AbstractBaseEntity
{

    /**
     * @var \OpenCoders\Podb\Session\SessionManager
     */
    private $sessionmanager;

    function __construct()
    {
        $this->sessionmanager = new SessionManager();
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return array();
    }

    /**
     * @return array
     */
    public function asShortArray()
    {
        return array();
    }

    /**
     * @param $apiVersion
     * @return array
     */
    public function getAPIInformation($apiVersion)
    {
        return array();
    }

    /**
     * @param $apiVersion
     * @return array
     */
    public function asArrayWithAPIInformation($apiVersion)
    {
        return array_merge($this->asArray(), $this->getAPIInformation($apiVersion));
    }

    /**
     * @param $apiVersion
     * @return array
     */
    public function asShortArrayWithAPIInformation($apiVersion)
    {
        return array_merge($this->asShortArray(), $this->getAPIInformation($apiVersion));
    }

    /**
     * @return string
     */
    protected function getBaseAPIUrl()
    {
        return ApiUrl::getBaseApiUrl();
    }

    /**
     * Returns the actual Session
     *
     * @return Session
     */
    protected function getSession()
    {
        return $this->sessionmanager->getSession();
    }

    protected function getEntityManager()
    {
        return Doctrine::getEntityManager();
    }
} 