<?php

namespace OpenCoders\Podb\Api\v1;

use Doctrine\Common\Collections\ArrayCollection;
use Luracast\Restler\RestException;
use OpenCoders\Podb\Api\AbstractBaseApi;
use OpenCoders\Podb\Persistence\Entity\Domain;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Persistence\Entity\User;

class Projects extends AbstractBaseApi
{
    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\Podb\Persistence\Entity\Project';

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
        $project = $this->getProject($projectName);

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
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function getMembers($projectName)
    {

        $data = array();

        $project = $this->getProject($projectName);

        if ($project == null) {
            throw new RestException(404);
        }

        /**
         * @var $user User
         */
        foreach ($project->getUsers() as $user) {
            $data[] = $user->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return $data;
    }

    /**
     * @param $projectName
     *
     * @url GET /projects/:projectName/domains
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function getDomains($projectName)
    {
        $data = array();

        $project = $this->getProject($projectName);

        if ($project == null) {
            throw new RestException(404);
        }

        /**
         * @var $domain Domain
         */
        foreach ($project->getDomains() as $domain) {
            $data[] = $domain->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return $data;
    }

    /**
     * @param $projectName
     * @url GET /projects/:projectName/languages
     *
     * @return array
     */
    public function getLanguages($projectName)
    {
        $apiBaseUrl = ApiUrl::getBaseApiUrl();

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

        try {
            $em = $this->getEntityManager();
            $em->persist($project);
            $em->flush();
        } catch (\Exception $e) {
            throw new RestException(400, 'Invalid parameters' . $e->getMessage());
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

            // TODO kann das hier bleiben
            if (isset($request_data['users'])) {
                $userIds = explode(',', $request_data['users']);
                $users = new ArrayCollection();
                foreach ($userIds as $userId) {
                    $user = $this->getEntityManager()->getRepository('OpenCoders\Podb\Persistence\Entity\User')->find($userId);
                    if ($user) {
                        $users->add($user);
                    }
                }
                $project->setUsers($users);
            }

            $this->getEntityManager()->flush($project);
        } catch (PodbException $e) {
            throw new RestException(400, $e->getMessage());
        }
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

    /**
     * @param $projectName
     * @return Project
     */
    private function getProject($projectName)
    {
        /** @var $project Project */
        if (intval($projectName) == 0) {
            $project = $this->getRepository()->findOneBy(array('name' => $projectName));
            return $project;
        } else {
            $project = $this->getRepository()->find($projectName);
            return $project;
        }
    }

}