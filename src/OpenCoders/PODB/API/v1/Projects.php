<?php

namespace OpenCoders\PODB\API\v1;


use OpenCoders\PODB\helper\Server;

class Projects {

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
                'url' => $apiBaseUrl . "/projects/Fake-Project-1",
                'url_html' => '',
                'url_members' => $apiBaseUrl . "/projects/Fake-Project-1/members",
                'url_domains' => $apiBaseUrl . "/projects/Fake-Project-1/domains",
                'url_languages' => $apiBaseUrl . "/projects/Fake-Project-1/languages"
            ),
            array(
                'id' => 12344567,
                'name' => 'Fake-Project-2',
                'owner' => array(),
                'url' => $apiBaseUrl . "/projects/Fake-Project-2",
                'url_html' => '',
                'url_members' => $apiBaseUrl . "/projects/Fake-Project-2/members",
                'url_domains' => $apiBaseUrl . "/projects/Fake-Project-2/domains",
                'url_languages' => $apiBaseUrl . "/projects/Fake-Project-2/languages"
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
            'url' => $apiBaseUrl . "/projects/{$projectName}",
            'url_html' => '',
            'url_members' => $apiBaseUrl . "/projects/{$projectName}/members",
            'url_domains' => $apiBaseUrl . "/projects/{$projectName}/domains",
            'url_languages' => $apiBaseUrl . "/projects/{$projectName}/languages",
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
        return array();
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName/domains
     *
     * @return array
     */
    public function getDomains($projectName)
    {
        return array();
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
                'url' => $apiBaseUrl . "/languages/de_DE",
                'url_Projects' => $apiBaseUrl . "/languages/de_DE/projects"
            ),
            array(
                'id' => 3,
                'locale' => 'en_US',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/languages/en_US",
                'url_Projects' => $apiBaseUrl . "/languages/en_US/projects"
            )
        );
    }
} 