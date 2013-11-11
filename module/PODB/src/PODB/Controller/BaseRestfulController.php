<?php

namespace PODB\Controller;


use PODB\Repository\Repository;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class BaseRestfulController extends AbstractRestfulController {

    protected $repositoryName;

    public function getList()
    {
        $users = $this->getRepository()->getAll();

        $output = array();
        foreach ($users as $user) {
            $output[] = $user->asArray();
        }

        return new JsonModel($output);
    }

    /**
     * @return Repository
     */
    protected function getRepository()
    {
        return $this->getServiceLocator()->get($this->repositoryName);
    }

    public function get($id)
    {
        # code...
    }

    public function delete($id)
    {
        # code...
    }
}