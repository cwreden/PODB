<?php

namespace OpenCoders\PODB\API\v1;

class Languages
{

    /**
     * @url /languages
     *
     * @return array
     */
    public function getList()
    {
        return array();
    }

    /**
     * @param $abbreviation
     * @url /languages/:abbreviation
     *
     * @return array
     */
    public function get($abbreviation)
    {
        return array();
    }

    /**
     * @param $abbreviation
     * @url /languages/:abbreviation/projects
     *
     * @return array
     */
    public function getProjects($abbreviation)
    {
        return array();
    }
} 