<?php

namespace OpenCoders\PODB\API\v1;


class DataSets {

    /**
     * @url GET /datasets
     *
     * @return array
     */
    public function getList()
    {
        return array();
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
        return array();
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
        return array();
    }
}