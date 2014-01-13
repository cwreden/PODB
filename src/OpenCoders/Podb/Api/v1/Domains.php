<?php

namespace OpenCoders\Podb\Api\v1;

use DateTime;
use Luracast\Restler\RestException;
use OpenCoders\Podb\Api\AbstractBaseApi;
use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Domain;
use OpenCoders\Podb\Persistence\Entity\Project;

class Domains extends AbstractBaseApi
{

    private $apiVersion = 'v1';

    /**
     * Returns a list of domains
     *
     * @url GET /domains
     *
     * @return array
     */
    public function getList()
    {
        $response = array();
        $domains = $this->getRepository()->findAll();

        /** @var $domain Domain */
        foreach ($domains as $domain) {
            $response[] = $domain->asShortArrayWithAPIInformation($this->getApiVersion());
        }

        return $response;
    }

    /**
     * Returns a specific domain
     *
     * @param $projectName
     * @param $domainName
     *
     * @url GET /domains/:projectName/:domainName
     * @url GET /domains/:projectName
     *
     * @throws RestException
     *
     * @return array
     */
    public function get($projectName, $domainName = null)
    {
        $domain = $this->getDomain($projectName, $domainName);

        if (!$domain) {
            throw new RestException(404, 'project not found with identifier ' . $projectName);
        }

        return $domain->asArrayWithAPIInformation($this->getApiVersion());
    }

    /**
     * Returns the translated Languages
     *
     * @param $projectName
     * @param $domainName
     *
     * @url GET /domains/:projectName/:domainName/translated_languages
     *
     * @return array
     */
    public function getTranslatedLanguages($projectName, $domainName)
    {
        $apiBaseUrl = ApiUrl::getBaseApiUrl();

        return array(
            array(
                'id' => 2,
                'locale' => 'en_GB',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_GB",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_GB/projects"
            )
        );
    }

    /**
     *
     *
     * @param $projectName
     * @param $domainName
     * @url GET /domains/:projectName/:domainName/datasets
     *
     * @return array
     */
    public function getDataSets($projectName, $domainName)
    {
        $apiBaseUrl = ApiUrl::getBaseApiUrl();

        return array(
            array(
                'id' => 1,
                'domain' => 'Fake-Domain-2',
                'project' => 'Fake-Project-2',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/datasets/1",
                'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
                'url_domain' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2",
                'url_translations' => $apiBaseUrl . "/{$this->apiVersion}/datasets/1/translations"
            ),
            array(
                'id' => 3,
                'domain' => 'Fake-Domain-2',
                'project' => 'Fake-Project-2',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/datasets/3",
                'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
                'url_domain' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2",
                'url_translations' => $apiBaseUrl . "/{$this->apiVersion}/datasets/3/translations"
            )
        );
    }

    /**
     * Creates a new domain with given data
     *
     * @param array $request_data Data to create new domain
     *
     * @url POST /domains
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function post($request_data = NULL)
    {
        $domain = new Domain();
        $domain->update($request_data);
        $domain->setCreateDate(new DateTime());
        $domain->setCreatedBy($this->getSession()->getUser());

        try {
            $em = $this->getEntityManager();
            $em->persist($domain);
            $em->flush();
        } catch (\Exception $e) {
            throw new RestException(400, 'Invalid parameters' . $e->getMessage());
        }

        return $domain->asArrayWithAPIInformation($this->getApiVersion());
    }

    /**
     * Updates a domain
     *
     * @param $id
     * @param $request_data
     *
     * @url PUT /domains/:id
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

        /** @var Domain $domain */
        $domain = $this->getRepository()->find($id);

        try {
            $domain->update($request_data);
            $this->getEntityManager()->flush($domain);
        } catch (PodbException $e) {
            throw new RestException(400, $e->getMessage());
        }

        return $domain->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * Deletes a domain by ID
     *
     * @param string $id ID of the domain
     *
     * @url DELETE /domains/:id
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

    private function getDomain($projectName, $domainName = null)
    {

        $domain = null;
        if ($this->isId($projectName)) {
            $domain = $this->getRepository()->find($projectName);
        } else if (is_string($projectName) && is_string($domainName)) {
            /** @var Project $project */
            $project = $this->getProjectRepository()->findOneBy(array('name' => $projectName));
            $domain = $this->getRepository()->findOneBy(array('projectId' => $project->getId(), 'name' => $domainName));
        }

        if ($domain) {
            return $domain;
        }

        return null;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getProjectRepository()
    {
        return $this->getEntityManager()->getRepository('OpenCoders\Podb\Persistence\Entity\Project');
    }

}