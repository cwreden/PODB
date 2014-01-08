<?php

namespace OpenCoders\PODB\API\v1;

use DateTime;
use Luracast\Restler\RestException;
use OpenCoders\PODB\API\AbstractBaseApi;
use OpenCoders\PODB\Entity\Project;
use OpenCoders\PODB\Exception\PodbException;
use OpenCoders\PODB\helper\Server;

class Projects extends AbstractBaseApi
{

    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\PODB\Entity\Project';

    /**
     * @url GET /projects
     *
     * @return array
     */
    public function getList()
    {
        $response = array();
        $projects = $this->getRepository()->findAll();

        /** @var $project Project */
        foreach ($projects as $project) {
            $response[] = $project->asShortArrayWithAPIInformation($this->getApiVersion());
        }

        return $response;
    }

    /**
     * @param string|int $projectName The name of the project or its ID
     *
     * @url GET /projects/:projectName
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function get($projectName)
    {
        /** @var $project Project */
        if (is_int($projectName)) {
            $project = $this->getRepository()->find($projectName);
        } else {
            $project = $this->getRepository()->findOneBy(array('name' => $projectName));
        }

        if (!$project) {
            throw new RestException(404, 'project not found with identifier ' . $projectName);
        }

        return $project->asArrayWithAPIInformation($this->getApiVersion());
    }

    /**
     *
     * @param string|int $projectName The name of the project or its ID
     *
     * @url GET /projects/:projectName/members
     *
     * @return array
     */
    public function getMembers($projectName)
    {
        $baseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 123456789,
                'username' => 'dax',
                'prename' => 'André',
                'name' => 'Meyerjürgens',
                'created_at' => 4356852635423,
                'modified_at' => 4356852635423,
                'url_user' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_projects' => $baseUrl . "/{$this->apiVersion}/users/dax/projects",
                'url_languages' => $baseUrl . "/{$this->apiVersion}/users/dax/languages",
                'url_translations' => $baseUrl . "/{$this->apiVersion}/users/dax/translations",
            ),
            array(
                'id' => 987654321,
                'username' => 'hans',
                'prename' => 'André',
                'name' => 'Meyerjürgens',
                'created_at' => 4356852635423,
                'modified_at' => 4356852635423,
                'url_user' => $baseUrl . "/{$this->apiVersion}/users/hans",
                'url_projects' => $baseUrl . "/{$this->apiVersion}/users/hans/projects",
                'url_languages' => $baseUrl . "/{$this->apiVersion}/users/hans/languages",
                'url_translations' => $baseUrl . "/{$this->apiVersion}/users/hans/translations",
            )
        );
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName/domains
     *
     * @return array
     */
    public function getDomains($projectName)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 2,
                'name' => 'Fake-Domain-2',
                'project' => 'Fake-Project-2',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2",
                'url_project' => $apiBaseUrl . "/{$this->apiVersion}/projects/Fake-Project-2",
                'url_translated_languages' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2/translated_languages",
                'url_datasets' => $apiBaseUrl . "/{$this->apiVersion}/domains/Fake-Project-2/Fake-Domain-2/datasets",
                'created_at' => 1389051097,
                'updated_at' => 1389051097
            )
        );
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName/languages
     *
     * @return array
     */
    public function getLanguages($projectName)
    {
        $apiBaseUrl = Server::getBaseApiUrl();

        return array(
            array(
                'id' => 1,
                'locale' => 'de_DE',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/de_DE",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/de_DE/projects"
            ),
            array(
                'id' => 3,
                'locale' => 'en_US',
                'label' => 'Deutsch',
                'url' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_US",
                'url_projects' => $apiBaseUrl . "/{$this->apiVersion}/languages/en_US/projects"
            )
        );
    }

    /**
     * Creates a new project
     * @param array|null $request_data Array containing data of new project
     *
     * @url POST /projects
     * @protected
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function post($request_data = null)
    {
        $project = new Project();

        $project->setName($request_data['name']);
        $project->setCreateDate(new DateTime());
        $project->setLastUpdateDate(new DateTime());

        try {
            $this->getEntityManager()->flush($project);
        } catch (\Exception $e) {
            throw new RestException(400, 'Invalid parameters');
        }

        return $project->asArrayWithAPIInformation($this->getApiVersion());
    }

    /**
     * Updates a project
     * @param int $id ID project
     * @param array|null $request_data Array with data to update
     *
     * @url PUT /projects/:id
     * @protected
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function put($id, $request_data = null)
    {
        if (!is_int($id)) {
            throw new RestException(400, 'Cannot update. Project with given ID ' . $id . ' does not exists');
        }

        /** @var Project $project */
        $project = $this->getRepository()->find($id);

        try {
            $project->update($request_data);
        } catch (PodbException $e) {
            throw new RestException(400, $e->getMessage());
        }

        $this->getEntityManager()->flush($project);
        return $project->asArrayWithAPIInformation($this->getApiVersion());
    }

    /**
     * Deletes a project
     * @param $id
     *
     * @url DELETE /projects/:id
     * @protected
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function delete($id)
    {
        if (intval($id) == 0) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }
        try {
            $project = $this->getRepository()->find($id);
            $this->getEntityManager()->remove($project);
            return array('success' => true);
        } catch (\Exception $e) {
            throw new RestException(400, 'Could not delete project');
        }
    }

}