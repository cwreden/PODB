<?php

namespace OpenCoders\PODB\API\v1;


class Domains {

    /**
     * @url GET /domains
     *
     * @return array
     */
    public function getList()
    {
        return array();
    }

    /**
     * @param $projectName
     * @param $domainName
     * @url GET /domains/:projectName/:domainName
     *
     * @return array
     */
    public function get($projectName, $domainName)
    {
        return array();
    }

    /**
     * @param $projectName
     * @param $domainName
     * @url GET /domains/:projectName/:domainName/translated_languages
     *
     * @return array
     */
    public function getTranslatedLanguages($projectName, $domainName)
    {
        return array();
    }

    /**
     * @param $projectName
     * @param $domainName
     * @url GET /domains/:projectName/:domainName/datasets
     *
     * @return array
     */
    public function getDataSets($projectName, $domainName)
    {
        return array();
    }

} 