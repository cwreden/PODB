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
     *
     * @url POST /translations
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function post($request_data = NULL)
    {
        try {
            $translation = new Translation();

            $translation->setDataSetId($request_data['dataSetId']);
            $translation->setLanguageId($request_data['languageId']);
            $translation->setMsgStr($request_data['msgStr']);
            if (isset($request_data['msgStr1'])) {
                $translation->setMsgStr1($request_data['msgStr1']);
            }
            if (isset($request_data['msgStr2'])) {
                $translation->setMsgStr2($request_data['msgStr2']);
            }
            $translation->setFuzzy($request_data['fuzzy']);

            $em = $this->getEntityManager();
            $em->persist($translation);
            $em->flush();
        } catch (\Exception $e) {
            throw new RestException(400, $e->getMessage());
        };

        return $translation->asArrayWithAPIInformation($this->apiVersion);
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
        $translation = $em->getPartialReference($this->entityName, array('id' => $id));
        $em->remove($translation);
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