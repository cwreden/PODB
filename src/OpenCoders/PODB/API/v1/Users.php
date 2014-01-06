<?php

namespace OpenCoders\PODB\API\v1;


class Users {

    /**
     * @url GET /users
     *
     * @return array
     */
    public function getList()
    {
        return array();
    }

    /**
     * @param $username
     * @url GET /users/:username
     *
     * @return array
     */
    public function get($username)
    {
        return array();
    }

    /**
     * @param $userName
     * @url GET /users/:userName/projects
     *
     * @return array
     */
    public function getProjects($userName)
    {
        return array();
    }

    /**
     * @param $userName
     * @url GET /users/:userName/languages
     *
     * @return array
     */
    public function getLanguages($userName)
    {
        return array();
    }

    /**
     * @param $userName
     * @url GET /users/:userName/translations
     *
     * @return array
     */
    public function getTranslations($userName)
    {
        return array();
    }

} 