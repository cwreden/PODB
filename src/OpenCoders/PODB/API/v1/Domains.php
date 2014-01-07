<?php

namespace OpenCoders\PODB\API\v1;


use OpenCoders\PODB\helper\Server;

class Domains {

    private $version = 'v1';

    /**
     * @url GET /domains
     *
     * @return array
     */
    public function getList()
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 1,
                'name' => 'Fake-Domain-1',
                'project' => 'Fake-Project-1',
                'url' => $apiBaseUrl . "/{$this->version}/domains/Fake-Project-1/Fake-Domain-1",
                'url_project' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-1",
                'url_translated_languages' => $apiBaseUrl . "/{$this->version}/domains/Fake-Project-1/Fake-Domain-1/translated_languages",
                'url_datasets' => $apiBaseUrl . "/{$this->version}/domains/Fake-Project-1/Fake-Domain-1/datasets",
                'created_at' => 1389051097,
                'updated_at' => 1389051097
            ),
            array(
                'id' => 2,
                'name' => 'Fake-Domain-2',
                'project' => 'Fake-Project-2',
                'url' => $apiBaseUrl . "/{$this->version}/domains/Fake-Project-2/Fake-Domain-2",
                'url_project' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-2",
                'url_translated_languages' => $apiBaseUrl . "/{$this->version}/domains/Fake-Project-2/Fake-Domain-2/translated_languages",
                'url_datasets' => $apiBaseUrl . "/{$this->version}/domains/Fake-Project-2/Fake-Domain-2/datasets",
                'created_at' => 1389051097,
                'updated_at' => 1389051097
            )
        );
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
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            'id' => 12362,
            'name' => $domainName,
            'project' => $projectName,
            'url' => $apiBaseUrl . "/{$this->version}/domains/{$projectName}/{$domainName}",
            'url_project' => $apiBaseUrl . "/{$this->version}/projects/{$projectName}",
            'url_translated_languages' => $apiBaseUrl . "/{$this->version}/domains/{$projectName}/{$domainName}/translated_languages",
            'url_datasets' => $apiBaseUrl . "/{$this->version}/domains/{$projectName}/{$domainName}/datasets",
            'created_at' => 1389051097,
            'updated_at' => 1389051097
        );
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