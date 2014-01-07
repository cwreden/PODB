<?php

namespace OpenCoders\PODB\API\v1;


use OpenCoders\PODB\helper\Server;

class Domains {

    private $apiVersion = 'v1';

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
                'url' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-1/Fake-Domain-1",
                'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1",
                'url_translated_languages' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-1/Fake-Domain-1/translated_languages",
                'url_datasets' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-1/Fake-Domain-1/datasets",
                'created_at' => 1389051097,
                'updated_at' => 1389051097
            ),
            array(
                'id' => 2,
                'name' => 'Fake-Domain-2',
                'project' => 'Fake-Project-2',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2",
                'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
                'url_translated_languages' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2/translated_languages",
                'url_datasets' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2/datasets",
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
            'url' => $apiBaseUrl . "/{$this->apiVersion}/domains/{$projectName}/{$domainName}",
            'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/{$projectName}",
            'url_translated_languages' => $apiBaseUrl . "/{$this->apiVersion}/domains/{$projectName}/{$domainName}/translated_languages",
            'url_datasets' => $apiBaseUrl . "/{$this->apiVersion}/domains/{$projectName}/{$domainName}/datasets",
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
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 2,
                'locale' => 'en_GB',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_GB",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_GB/projects"
            )
        );
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
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 1,
                'domain' => 'Fake-Domain-2',
                'project' => 'Fake-Project-2',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/datasets/1",
                'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
                'url_domain' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2",
                'url_translations' => $apiBaseUrl . "/{$this->apiVersion}/datasets/1/translations"
            ),
            array(
                'id' => 3,
                'domain' => 'Fake-Domain-2',
                'project' => 'Fake-Project-2',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/datasets/3",
                'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
                'url_domain' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2",
                'url_translations' => $apiBaseUrl . "/{$this->apiVersion}/datasets/3/translations"
            )
        );
    }

} 