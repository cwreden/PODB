<?php

namespace OpenCoders\PODB\API\v1;


class DataSet {

    /**
     * @param $id
     *
     * @url GET /dataSets/:id
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
     * @URL GET /dataSets/:id/translations
     *
     * @return array
     */
    public function getTranslations($id)
    {
        return array();
    }
}