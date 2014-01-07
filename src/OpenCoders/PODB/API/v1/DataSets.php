<?php

namespace OpenCoders\PODB\API\v1;


use OpenCoders\PODB\helper\Server;

class DataSets {

    private $apiVersion = 'v1';

    /**
     * @url GET /datasets
     *
     * @return array
     */
    public function getList()
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
                'id' => 2,
                'domain' => 'Fake-Domain-1',
                'project' => 'Fake-Project-1',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/datasets/2",
                'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1",
                'url_domain' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-1/Fake-Domain-1",
                'url_translations' => $apiBaseUrl . "/{$this->apiVersion}/datasets/2/translations"
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

    /**
     * @param $id
     *
     * @url GET /datasets/:id
     *
     * @return array
     */
    public function get($id)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            'id' => $id,
            'domain' => 'Fake-Domain-2',
            'project' => 'Fake-Project-2',
            'url' => $apiBaseUrl . "/{$this->apiVersion}/datasets/{$id}",
            'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
            'url_domain' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2",
            'url_translations' => $apiBaseUrl . "/{$this->apiVersion}/datasets/{$id}/translations",
            'created_at' => 1389051097,
            'updated_at' => 1389051097
        );
    }

    /**
     * @param $id
     *
     * @url GET /datasets/:id/translations
     *
     * @return array
     */
    public function getTranslations($id)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 2,
                'locale' => 'en_GB',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_GB",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_GB/projects"
            ),
            array(
                'id' => 3,
                'locale' => 'en_US',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_US",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_US/projects"
            )
        );
    }
}