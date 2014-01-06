<?php

namespace OpenCoders\API\v1;


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
     * @param $username
     * @url GET /users/:username/projects
     *
     * @return array
     */
    public function getProjects($username)
    {
        return array();
    }

    /**
     * @param $username
     * @url GET /users/:username/languages
     *
     * @return array
     */
    public function getLanguages($username)
    {
        return array();
    }

    /**
     * @param $username
     * @url GET /users/:username/translations
     *
     * @return array
     */
    public function getTranslations($username)
    {
        return array();
    }

} 