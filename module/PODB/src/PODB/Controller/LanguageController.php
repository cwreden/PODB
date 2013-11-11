<?php

namespace PODB\Controller;

use Exception;
use PODB\Entity\Language;
use Zend\View\Model\JsonModel;

class LanguageController extends BaseRestfulController
{
    protected $repositoryName = 'PODB\Repository\Language';

    public function create($data)
    {
        $event = new Language();
        $event->setName($data['name']);
        $event->setLocale($data['locale']);
        return new JsonModel(array('id' => $this->getRepository()->create($event)));
    }

    public function update($id, $data)
    {
        # code...
    }
}