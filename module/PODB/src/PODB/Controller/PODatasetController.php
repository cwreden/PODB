<?php

namespace PODB\Controller;

use DateTime;
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

    /**
     * @param mixed $id
     * @return mixed|JsonModel
     */
    public function get($id)
    {
        return new JsonModel($this->getRepository()->get($id)->asArray());
    }

    /**
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        $object = new PODataSet();

        //ToDo: Daten müssen noch gesetzt werden

        $now = new DateTime();
        $object->setCreateDate($now);
        $object->setLastUpdateDate($now);

        return new JsonModel(array('id' => $this->getRepository()->create($object)));
    }

    /**
     * @param string $id
     * @param array $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        try {
            $object = $this->getRepository()->get($id);
            $object->setLastUpdateDate(new DateTime());
            $this->getRepository()->update($object);
            return new JsonModel(array('successfull' => 'true'));
        } catch (Exception $e) {
            return $this->getErrorModel($e);
        }
    }

    /**
     * @param string $id
     * @return JsonModel
     */
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