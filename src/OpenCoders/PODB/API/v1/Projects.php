<?php

namespace OpenCoders\PODB\API\v1;


class Projects {

    /**
     * @url GET /projects
     *
     * @return array
     */
    public function getList()
    {
        return array();
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName
     *
     * @return array
     */
    public function get($projectName)
    {
        return array();
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName/users
     *
     * @return array
     */
    public function getUsers($projectName)
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
        return array();
    }
} 