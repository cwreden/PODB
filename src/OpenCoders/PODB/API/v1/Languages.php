<?php

namespace OpenCoders\PODB\API\v1;

use OpenCoders\PODB\helper\Server;

class Languages
{

    private $version = 'v1';

    /**
     * @url GET /languages
     *
     * @return array
     */
    public function getList()
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 1,
                'locale' => 'de_DE',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->version}/languages/de_DE",
                'url_Projects' => $apiBaseUrl . "/{$this->version}/languages/de_DE/projects"
            ),
            array(
                'id' => 2,
                'locale' => 'en_GB',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->version}/languages/en_GB",
                'url_Projects' => $apiBaseUrl . "/{$this->version}/languages/en_GB/projects"
            ),
            array(
                'id' => 3,
                'locale' => 'en_US',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->version}/languages/en_US",
                'url_Projects' => $apiBaseUrl . "/{$this->version}/languages/en_US/projects"
            )
        );
    }

    /**
     * @param $abbreviation
     * @url GET /languages/:abbreviation
     *
     * @return array
     */
    public function get($abbreviation)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            'id' => 1,
            'locale' => $abbreviation,
            'label' => 'Language 1',
            'url' => $apiBaseUrl . "/{$this->version}/languages/{$abbreviation}",
            'url_Projects' => $apiBaseUrl . "/{$this->version}/languages/{$abbreviation}/projects",
            'created_at' => 1389051097,
            'updated_at' => 1389051097
        );
    }

    /**
     * @param $abbreviation
     * @url GET /languages/:abbreviation/projects
     *
     * @return array
     */
    public function getProjects($abbreviation)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 12344567,
                'name' => 'Fake-Project-1',
                'owner' => array(),
                'url' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-1",
                'url_html' => '',
                'url_members' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-1/members",
                'url_domains' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-1/domains",
                'url_languages' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-1/languages"
            ),
            array(
                'id' => 12344567,
                'name' => 'Fake-Project-2',
                'owner' => array(),
                'url' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-2",
                'url_html' => '',
                'url_members' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-2/members",
                'url_domains' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-2/domains",
                'url_languages' => $apiBaseUrl . "/{$this->version}/projects/Fake-Project-2/languages"
            )
        );
    }
} 