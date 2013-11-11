<?php

namespace PODB\Controller;


use Exception;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class BaseRestfulController extends AbstractRestfulController {

    /**
     * @param $e
     * @return JsonModel
     */
    public function getErrorModel(Exception $e)
    {
        $this->response->setStatusCode(500);
        return new JsonModel(array('error' => 'true', 'code' => $e->getCode(), 'message' => $e->getMessage()));
    }
}