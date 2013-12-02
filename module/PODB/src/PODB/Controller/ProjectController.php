<?php

namespace PODB\Controller;

use DateTime;
use Exception;
use PODB\Entity\Project;
use PODB\Repository\ProjectRepository;
use Zend\View\Model\JsonModel;

class ProjectController extends BaseRestfulController
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
        $object = new Project();
        $object->setName($data['name']);
        $object->setDefaultLanguage($data['defaultLanguage']);
        $object->setUsers($data['users']);

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
            $object->setName($data['name']);
            $object->setDefaultLanguage($data['defaultLanguage']);
            $object->setUsers($data['users']);
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
     * @return ProjectRepository
     */
    protected function getRepository()
    {
        return $this->getServiceLocator()->get('PODB\Repository\Project');
    }
}