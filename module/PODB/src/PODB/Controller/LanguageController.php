<?php

namespace PODB\Controller;

use Exception;
use PODB\Entity\Language;
use PODB\Repository\LanguageRepository;
use Zend\View\Model\JsonModel;

class LanguageController extends BaseRestfulController
{
    public function getList()
    {
        $users = $this->getRepository()->getAll();

        $output = array();
        foreach ($users as $user) {
            $output[] = $user->asArray();
        }

        return new JsonModel($output);
    }

    public function get($id)
    {
        return new JsonModel($this->getRepository()->get($id)->asArray());
    }

    public function create($data)
    {
        $language = new Language();
        $language->setName($data['name']);
        $language->setLocale($data['locale']);
        $language->setCreateDate(time());
        return new JsonModel(array('id' => $this->getRepository()->create($language)));
    }

    public function update($id, $data)
    {
        try {
            $language = $this->getRepository()->get($id);
            $language->setName($data['name']);
            $language->setLocale($data['locale']);
            $language->setLastUpdateDate(time());
            $this->getRepository()->update($language);
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
     * @return LanguageRepository
     */
    protected function getRepository()
    {
        return $this->getServiceLocator()->get('PODB\Repository\Language');
    }
}