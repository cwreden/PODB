<?php

namespace OpenCoders\Podb\Api\v1;


use Luracast\Restler\RestException;
use OpenCoders\Podb\Api\AbstractBaseApi;
use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\DataSet;

class DataSets extends AbstractBaseApi
{
    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\Podb\Persistence\Entity\DataSet';

    /**
     * @url GET /datasets
     *
     * @return array
     */
    public function getList()
    {
        $data = array();

        $repository = $this->getRepository();
        $dataSets = $repository->findAll();

        /** @var $dataSet DataSet */
        foreach ($dataSets as $dataSet) {
            $data[] = $dataSet->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return $data;
    }

    /**
     * @param $id
     *
     * @url GET /datasets/:id
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function get($id)
    {
        $dataSet = $this->getDataSet($id);

        if ($dataSet == null) {
            throw new RestException(404, "No data set found with identifier $id.");
        }
        return $dataSet->asArrayWithAPIInformation($this->apiVersion);
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
        $apiBaseUrl = ApiUrl::getBaseApiUrl();

        return array(
            array(
                'id' => 2,
                'locale' => 'en_GB',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_GB",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_GB/projects"
            ),
            array(
                'id' => 3,
                'locale' => 'en_US',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_US",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_US/projects"
            )
        );
    }

    /**
     * @param $request_data
     *
     * @url POST /datasets
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function post($request_data = NULL)
    {
        try {
            $dataSet = new DataSet();
            $dataSet->setMsgId($request_data['msgId']);
            $dataSet->setDomainId($request_data['domainId']);

            $em = $this->getEntityManager();
            $em->persist($dataSet);
            $em->flush();
        } catch (PodbException $e) {
            throw new RestException(400, $e->getMessage());
        };

        return $dataSet->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * @param $id
     * @param $request_data
     * @url PUT /datasets/:id
     */
    public function put($id, $request_data = NULL)
    {
        if (!$this->isId($id)) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }

        /** @var $dataSet DataSet*/
        $dataSet = $this->getRepository()->find($id);

        try {
            $dataSet->update($request_data);
            $this->getEntityManager()->flush($dataSet);
        } catch (PodbException $e) {
            throw new RestException(400, $e->getMessage());
        }

        return $dataSet->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * @param $id
     *
     * @url DELETE /datasets/:id
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
        $object = $em->getPartialReference($this->entityName, array('id' => $id));
        $em->remove($object);
        $em->flush();

        return array(
            'success' => true
        );
    }

    /**
     * @param $id
     *
     * @throws \OpenCoders\Podb\Exception\PodbException
     * @return DataSet
     */
    private function getDataSet($id)
    {
        $repository = $this->getRepository();

        /** @var $dataSet DataSet */
        if ($this->isId($id)) {
            $dataSet = $repository->find($id);
        } else {
            throw new PodbException('Invalid id.');
        }
        return $dataSet;
    }
}