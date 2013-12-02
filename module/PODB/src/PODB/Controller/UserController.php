<?php

namespace PODB\Controller;

use DateTime;
use Exception;
use PODB\Entity\User;
use PODB\Repository\UserRepository;
use Zend\View\Model\JsonModel;

class UserController extends BaseRestfulController
{

    /**
     * Returns a list of Users
     *
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
     * Returns a User
     *
     * @param string $id
     * @return JsonModel
     */
    public function get($id)
    {
        return new JsonModel($this->getRepository()->get($id)->asArray());
    }

    /**
     * Creates a new User
     *
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        $object = new User();
        $object->setDisplayName($data['displayname']);
        $object->setUsername($data['username']);
        $object->setEmail($data['email']);
        $object->setPassword($data['password']);
        $object->setState($data['state']);
//        $object->setProjects($data['projectIds']);

        $now = new DateTime();
        $object->setLastUpdateDate($now);
        $object->setCreateDate($now);

        return new JsonModel(array('id' => $this->getRepository()->create($object)));
    }

    /**
     * Updates an User
     *
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
     * Removes a User by ID
     *
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
     * Returns the UserRepository
     *
     * @return UserRepository
     */
    protected function getRepository()
    {
        return $this->getServiceLocator()->get('PODB\Repository\User');
    }

}