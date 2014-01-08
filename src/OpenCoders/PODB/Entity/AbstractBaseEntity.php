<?php

namespace OpenCoders\PODB\Entity;


use OpenCoders\PODB\helper\Server;

class AbstractBaseEntity {

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
        return Server::getBaseApiUrl();
    }
} 