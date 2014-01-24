<?php

namespace OpenCoders\Podb\Api\v1;

use DateTime;
use Luracast\Restler\RestException;
use OpenCoders\Podb\Api\AbstractBaseApi;
use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Session\SessionManager;

class Languages extends AbstractBaseApi
{
    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\Podb\Persistence\Entity\Language';

    /**
     * @url GET /languages
     *
     * @return array
     */
    public function getList()
    {
        $data = array();

        $repository = $this->getRepository();
        $languages = $repository->findAll();

        /** @var $language Language */
        foreach ($languages as $language) {
            $data[] = $language->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return $data;
    }

    /**
     * @param $locale
     *
     * @url GET /languages/:locale
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function get($locale)
    {
        $language = $this->getLanguage($locale);

        if ($language == null) {
            throw new RestException(404, "No language found with identifier $locale.");
        }
        return $language->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * @param $locale
     *
     * @TODO rename to users and load user informations
     *
     * @url GET /languages/:locale/projects
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function getProjects($locale)
    {
        throw new RestException(501);

        $apiBaseUrl = ApiUrl::getBaseApiUrl();

        return array(
            array(
                'id' => 12344567,
                'name' => 'Fake-Project-1',
                'owner' => array(),
                'url' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1",
                'url_html' => '',
                'url_members' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1/members",
                'url_domains' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1/domains",
                'url_languages' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-1/languages"
            ),
            array(
                'id' => 12344567,
                'name' => 'Fake-Project-2',
                'owner' => array(),
                'url' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
                'url_html' => '',
                'url_members' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2/members",
                'url_domains' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2/domains",
                'url_languages' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2/languages"
            )
        );
    }

    /**
     * @param $request_data
     *
     * @url POST /languages
     * @protected
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function post($request_data = NULL)
    {
        try {
            $language = new Language();
            $language->setLocale($request_data['locale']);
            $language->setName($request_data['name']);

            $em = $this->getEntityManager();
            $em->persist($language);
            $em->flush();
        } catch (PodbException $e) {
            throw new RestException(400, $e->getMessage());
        };

        return $language->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * @param $id
     * @param $request_data
     *
     * @url PUT /languages/:id
     * @protected
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function put($id, $request_data = NULL)
    {
        if (!$this->isId($id)) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }

        /** @var Language $language */
        $language = $this->getRepository()->find($id);

        try {
            $language->update($request_data);
            $this->getEntityManager()->flush($language);
        } catch (PodbException $e) {
            throw new RestException(400, $e->getMessage());
        }

        return $language->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * @param $id
     *
     * @url DELETE /languages/:id
     * @protected
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function delete($id)
    {
        if (!$this->isId($id)) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }

        $em = $this->getEntityManager();
        $object = $em->getPartialReference($this->entityName, array('id' => $id));
        $em->remove($object);
        $em->flush();

        return array(
            'success' => true
        );
    }

    /**
     * @param $locale
     *
     * @return Language
     */
    private function getLanguage($locale)
    {
        $repository = $this->getRepository();

        /** @var $language Language */
        if ($this->isId($locale)) {
            $language = $repository->find($locale);
        } else {
            $language = $repository->findOneBy(array(
                'locale' => $locale
            ));
        }
        return $language;
    }
} 