<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Session\Session;
use OpenCoders\Podb\Session\SessionManager;

abstract class AbstractBaseEntity
{

    /**
     * @var SessionManager
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
     * @param int $apiVersion
     *
     * TODO extract api information out of entities
     *
     * @return array
     */
    public function getAPIInformation($apiVersion)
    {
        return array();
    }

    /**
     * @param int $apiVersion
     *
     * @return array
     */
    public function asArrayWithAPIInformation($apiVersion)
    {
        return array_merge($this->asArray(), $this->getAPIInformation($apiVersion));
    }

    /**
     * @param int $apiVersion
     *
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

    /**
     * Returns the EntityManager
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return Doctrine::getEntityManager();
    }
} 