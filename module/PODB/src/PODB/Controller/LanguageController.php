<?php

namespace PODB\Controller;

use DateTime;
use Exception;
use PODB\Entity\Language;
use PODB\Repository\LanguageRepository;
use Zend\View\Model\JsonModel;

class LanguageController extends BaseRestfulController
{
    /**
     * @return JsonModel
     */
    public function getList()
    {
        $users = $this->getRepository()->getAll();

        $output = array();
        foreach ($users as $user) {
            $output[] = $user->asShortArray();
        }

        return new JsonModel($output);
    }

    /**
     * @param string  $id
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
        $language = new Language();
        $language->setName($data['name']);
        $language->setLocale($data['locale']);

        $now = new DateTime();
        $language->setCreateDate($now);
        $language->setLastUpdateDate($now);

        return new JsonModel(array('id' => $this->getRepository()->create($language)));
    }

    /**
     * @param string $id
     * @param array $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        try {
            $language = $this->getRepository()->get($id);
            $language->setName($data['name']);
            $language->setLocale($data['locale']);
            $language->setLastUpdateDate(new DateTime());
            $this->getRepository()->update($language);
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
     * @return LanguageRepository
     */
    protected function getRepository()
    {
        return $this->getServiceLocator()->get('PODB\Repository\Language');
    }
}