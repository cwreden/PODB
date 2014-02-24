<?php

namespace OpenCoders\Podb\Api\v1;

use Luracast\Restler\RestException;
use OpenCoders\Podb\Api\AbstractBaseApi;
use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Persistence\Entity\Translation;

class Translations extends AbstractBaseApi
{

    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\Podb\Persistence\Entity\Translation';

    /**
     * @url GET /translations
     *
     * @return array
     */
    public function getList()
    {
        $response = array();
        $translations = $this->getRepository()->findAll();

        /** @var $translation Translation */
        foreach ($translations as $translation) {
            $response[] = $translation->asShortArrayWithAPIInformation($this->getApiVersion());
        }

        return $response;
    }

    /**
     * @param $id
     *
     * @url GET /translations/:id
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function get($id)
    {
        $translation = $this->getTranslation($id);

        if (!$translation) {
            throw new RestException(404, 'translation not found.');
        }

        return $translation->asArrayWithAPIInformation($this->getApiVersion());
    }

    /**
     * @param $request_data
     * @url POST /translations
     */
    public function post($request_data = NULL)
    {

    }

    /**
     * @param $id
     * @param $request_data
     * @url PUT /translations/:id
     */
    public function put($id, $request_data = NULL)
    {

    }

    /**
     * @param $id
     *
     * @url DELETE /translations/:id
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function delete($id)
    {

        if (!$this->isId($id)) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }

        $em = $this->getEntityManager();
        $user = $em->getPartialReference($this->entityName, array('id' => $id));
        $em->remove($user);
        $em->flush();

        return array(
            'success' => true
        );
    }

    /**
     * @param $id
     * @return Translation
     */
    private function getTranslation($id)
    {
        /** @var $translation Translation */
        $translation = $this->getRepository()->find($id);
        return $translation;
    }

}