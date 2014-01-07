<?php

namespace OpenCoders\PODB\API\v1;

use OpenCoders\PODB\helper\Server;

class Users
{
    private $apiVersion = 'v1';

    /**
     * @url GET /users
     *
     * @return array
     */
    public function getList()
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
     * @param $userName
     * @url GET /users/:userName
     *
     * @return array
     */
    public function get($userName)
    {

        $baseUrl = Server::getBaseApiUrl();

        return array(
            'id' => 1234567890,
            'username' => $userName,
            'prename' => 'André',
            'name' => 'Meyerjürgens',
            'created_at' => 4356852635423,
            'modified_at' => 4356852635423,
            'url_projects' => $baseUrl . "/{$this->apiVersion}/users/{$userName}/projects",
            'url_languages' => $baseUrl . "/{$this->apiVersion}/users/{$userName}/languages",
            'url_translations' => $baseUrl . "/{$this->apiVersion}/users/{$userName}/translations",
        );
    }

    /**
     * @param $userName
     * @url GET /users/:userName/projects
     *
     * @return array
     */
    public function getProjects($userName)
    {
        return array(
            array(
                'id' => 123456789,
                'name' => 'PODB',
                'default_language' => 'de_DE',
                'created_at' => 4356852635423,
                'modified_at' => 4356852635423,
            ),
            array(
                'id' => 987654321,
                'name' => 'PODB2',
                'default_language' => 'en_US',
                'created_at' => 4356852635423,
                'modified_at' => 4356852635423,
            ),
        );
    }

    /**
     * @param $userName
     * @url GET /users/:userName/languages
     *
     * @return array
     */
    public function getLanguages($userName)
    {

        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 1,
                'locale' => 'de_DE',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/languages/de_DE",
                'url_projects' => $apiBaseUrl . "/languages/de_DE/projects"
            ),
            array(
                'id' => 2,
                'locale' => 'en_GB',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/languages/en_GB",
                'url_projects' => $apiBaseUrl . "/languages/en_GB/projects"
            ),
        );
    }

    /**
     * @param $userName
     * @url GET /users/:userName/translations
     *
     * @return array
     */
    public function getTranslations($userName)
    {

        $baseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 123456789,
                'language' => 'en_US',
                'msg_str' => 'test',
                'msg_str1' => '',
                'msg_str2' => '',
                'fuzzy' => true,
                'created_at' => 12345678,
                'modified_at' => 12345678,
                'url_dataset' => $baseUrl . "/{$this->apiVersion}/datasets/123456789",
                'url_created_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_modified_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
            ),
            array(
                'id' => 123456789,
                'language' => 'en_US',
                'msg_str' => 'test',
                'msg_str1' => '',
                'msg_str2' => '',
                'fuzzy' => true,
                'created_at' => 12345678,
                'modified_at' => 12345678,
                'url_dataset' => $baseUrl . "/{$this->apiVersion}/datasets/123456789",
                'url_created_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_modified_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
            ),
            array(
                'id' => 123456789,
                'language' => 'en_US',
                'msg_str' => 'test',
                'msg_str1' => '',
                'msg_str2' => '',
                'fuzzy' => true,
                'created_at' => 12345678,
                'modified_at' => 12345678,
                'url_dataset' => $baseUrl . "/{$this->apiVersion}/datasets/123456789",
                'url_created_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_modified_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
            ),
            array(
                'id' => 123456789,
                'language' => 'en_US',
                'msg_str' => 'test',
                'msg_str1' => '',
                'msg_str2' => '',
                'fuzzy' => true,
                'created_at' => 12345678,
                'modified_at' => 12345678,
                'url_dataset' => $baseUrl . "/{$this->apiVersion}/datasets/123456789",
                'url_created_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_modified_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
            ),
        );
    }

} 