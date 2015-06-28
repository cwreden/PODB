<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Session\Session;
use OpenCoders\Podb\Session\SessionManager;

/**
 * Class AbstractBaseEntity
 * @package OpenCoders\Podb\Persistence\Entity
 * @deprecated
 */
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
     * @deprecated
     */
    public function asArray()
    {
        return array();
    }

    /**
     * @return array
     * @deprecated
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
     * TODO muss ausgelagert werden in eine helper klasse
     * @deprecated
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
     * TODO muss ausgelagert werden in eine helper klasse
     * @deprecated
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
     * TODO muss ausgelagert werden in eine helper klasse
     * @deprecated
     *
     * @return array
     */
    public function asShortArrayWithAPIInformation($apiVersion)
    {
        return array_merge($this->asShortArray(), $this->getAPIInformation($apiVersion));
    }

    /**
     * @return string
     * @deprecated
     */
    protected function getBaseAPIUrl()
    {
        return ApiUrl::getBaseApiUrl();
    }

    /**
     * Returns the actual Session
     * TODO wird dies genutzt???
     * @return Session
     * @deprecated
     */
    protected function getSession()
    {
        return $this->sessionmanager->getSession();
    }

    /**
     * Returns the EntityManager
     *
     * @return EntityManager
     * @deprecated
     */
    protected function getEntityManager()
    {
        return Doctrine::getEntityManager();
    }
} 