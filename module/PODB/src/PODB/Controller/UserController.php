<?php

namespace PODB\Controller;

use PODB\Entity\User;
use PODB\Repository\UserRepository;
use Zend\View\Model\JsonModel;

class UserController extends BaseRestfulController
{

    /**
     * @return JsonModel
     */
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
     * @param string $id
     * @return JsonModel
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
        $object = new User();
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
     * @return UserRepository
     */
    protected function getRepository()
    {
        return $this->getServiceLocator()->get('PODB\Repository\User');
    }

}