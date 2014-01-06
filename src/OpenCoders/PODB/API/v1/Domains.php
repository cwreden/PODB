<?php

namespace OpenCoders\PODB\API\v1;


class Domains {

    /**
     * @url GET /domains
     */
    public function getList()
    {
        return array();
    }

    /**
     * @url GET /domains/:projectName/:domainName
     */
    public function get($projactName, $domainName)
    {
        return array();
    }

    /**
     * @url GET /domains/:projectName/:domainName/translatedLanguages
     */
    public function getTranslatedLanguages($projectName, $domainName)
    {
        return array();
    }

    /**
     * @url GET /domains/:projectName/:domainName/datasets
     */
    public function getDataSets($projectName, $domainName)
    {
        return array();
    }

} 