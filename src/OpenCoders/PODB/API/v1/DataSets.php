<?php

namespace OpenCoders\PODB\API\v1;


class DataSet {

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