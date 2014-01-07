<?php

namespace OpenCoders\PODB\API\v1;


use OpenCoders\PODB\helper\Server;

class Projects {

    private $apiVersion = 'v1';

    /**
     * @url GET /projects
     *
     * @return array
     */
    public function getList()
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 12344567,
                'name' => 'Fake-Project-1',
                'owner' => array(),
                'url' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1",
                'url_html' => '',
                'url_members' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1/members",
                'url_domains' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1/domains",
                'url_languages' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1/languages"
            ),
            array(
                'id' => 12344567,
                'name' => 'Fake-Project-2',
                'owner' => array(),
                'url' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
                'url_html' => '',
                'url_members' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2/members",
                'url_domains' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2/domains",
                'url_languages' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2/languages"
            )
        );
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName
     *
     * @return array
     */
    public function get($projectName)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            'id' => 12344567,
            'name' => $projectName,
            'owner' => array(),
            'url' => $apiBaseUrl . "/{$this->apiVersion}/projects/{$projectName}",
            'url_html' => '',
            'url_members' => $apiBaseUrl . "/{$this->apiVersion}/projects/{$projectName}/members",
            'url_domains' => $apiBaseUrl . "/{$this->apiVersion}/projects/{$projectName}/domains",
            'url_languages' => $apiBaseUrl . "/{$this->apiVersion}/projects/{$projectName}/languages",
            'created_at' => 1389051097,
            'updated_at' => 1389051097
        );
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName/members
     *
     * @return array
     */
    public function getMembers($projectName)
    {
        $baseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 123456789,
                'username' => 'dax',
                'prename' => 'André',
                'name' => 'Meyerjürgens',
                'created_at' => 4356852635423,
                'modified_at' => 4356852635423,
                'url_user' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_projects' => $baseUrl . "/{$this->apiVersion}/users/dax/projects",
                'url_languages' => $baseUrl . "/{$this->apiVersion}/users/dax/languages",
                'url_translations' => $baseUrl . "/{$this->apiVersion}/users/dax/translations",
            ),
            array(
                'id' => 987654321,
                'username' => 'hans',
                'prename' => 'André',
                'name' => 'Meyerjürgens',
                'created_at' => 4356852635423,
                'modified_at' => 4356852635423,
                'url_user' => $baseUrl . "/{$this->apiVersion}/users/hans",
                'url_projects' => $baseUrl . "/{$this->apiVersion}/users/hans/projects",
                'url_languages' => $baseUrl . "/{$this->apiVersion}/users/hans/languages",
                'url_translations' => $baseUrl . "/{$this->apiVersion}/users/hans/translations",
            )
        );
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName/domains
     *
     * @return array
     */
    public function getDomains($projectName)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
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
     * @url GET /projects/:projectName/languages
     *
     * @return array
     */
    public function getLanguages($projectName)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 1,
                'locale' => 'de_DE',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/de_DE",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/de_DE/projects"
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

    /**
     * @url POST /projects
     */
    public function create($request_data = NULL)
    {
        return array(
            'data' => $request_data,
            'success' => true
        );
    }

    /**
     * @url PUT /projects/:projectName
     */
    public function update($projectName, $request_data = NULL)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            'data' => $request_data,
            'url' => $apiBaseUrl . "/{$this->apiVersion}/projects/{$projectName}",
            'success' => true
        );
    }

    /**
     * @url DELETE /projects/:projectName
     */
    public function remove($projectName)
    {
        return array(
            'name' => $projectName,
            'success' => true
        );
    }
} 