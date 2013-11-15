<?php

namespace PODB\Controller;

use Exception;
use PODB\Entity\PODataSet;
use PODB\Repository\PODatasetRepository;
use Zend\View\Model\JsonModel;

class PODatasetController extends BaseRestfulController
{
    public function getList()
    {
        $objects = $this->getRepository()->getAll();

        $output = array();
        foreach ($objects as $object) {
            $output[] = $object->asArray();
        }

        return new JsonModel($output);
    }

    public function get($id)
    {
        return new JsonModel($this->getRepository()->get($id)->asArray());
    }

    public function create($data)
    {
        $object = new PODataSet();
        $object->setCreateDate(time());
        return new JsonModel(array('id' => $this->getRepository()->create($object)));
    }

    public function update($id, $data)
    {
        try {
            $object = $this->getRepository()->get($id);
            $object->setLastUpdateDate(time());
            $this->getRepository()->update($object);
            return new JsonModel(array('successfull' => 'true'));
        } catch (Exception $e) {
            return $this->getErrorModel($e);
        }
    }

    public function delete($id)
    {
        try {
            $this->getRepository()->delete($id);
            return new JsonModel(array('successful' => 'true'));
        } catch (Exception $e) {
            return $this->getErrorModel($e);
        }
    }

    /**
     * @return PODatasetRepository
     */
    protected function getRepository()
    {
        return $this->getServiceLocator()->get('PODB\Repository\PODataset');
    }
}