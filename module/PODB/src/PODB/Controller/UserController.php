<?php

namespace PODB\Controller;

use PODB\Repository\UserRepository;
use \Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UserController extends AbstractRestfulController
{
    public function getList()
    {
        $users = $this->getEventRepository()->getAll();

        $output = array();
        foreach ($users as $user) {
            $output[] = $user->asArray();
        }

        return new JsonModel($output);
    }

    /**
     * @return UserRepository
     */
    private function getEventRepository()
    {
        return $this->getServiceLocator()->get('PODB\Repository\User');
    }

    public function get($id)
    {
        # code...
    }

    public function create($data)
    {
        # code...
    }

    public function update($id, $data)
    {
        # code...
    }

    public function delete($id)
    {
        # code...
    }
}