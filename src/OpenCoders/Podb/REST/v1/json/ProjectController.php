<?php

namespace OpenCoders\Podb\REST\v1\json;


use Exception;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\REST\v1\BaseController;
use OpenCoders\Podb\Service\ProjectService;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectController extends BaseController
{
    /**
     * @var ProjectService
     */
    private $projectService;

    function __construct(Application $app, ProjectService $projectService)
    {
        parent::__construct($app);
        $this->projectService = $projectService;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $projects = $this->projectService->getAll();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var Project $project */
        foreach ($projects as $project) {
            $urlParams = array('projectName' => $project->getName());
            $data[] = array(
                'id' => $project->getId(),
                'name' => $project->getName(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.project.get', $urlParams),
                )
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @param $projectName
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function get($projectName)
    {
        if ($this->isId($projectName)) {
            $project = $this->projectService->get($projectName);
        } else {
            $project = $this->projectService->getByName($projectName);
        }

        if ($project == null) {
            throw new Exception("No project found with identifier $projectName.", 404);
        }
        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('projectName' => $project->getName());

        return new JsonResponse(array(
            'id' => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
            'private' => $project->getPrivate(),
            'blog' => $project->getUrl(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.project.get', $urlParams),
                'owners' => $urlGenerator->generate('rest.v1.json.project.owner.list', $urlParams),
                'contributors' => $urlGenerator->generate('rest.v1.json.project.contributor.list', $urlParams),
                'categories' => $urlGenerator->generate('rest.v1.json.project.category.list', $urlParams),
                'languages' => $urlGenerator->generate('rest.v1.json.project.language.list', $urlParams),
            )
        ));
    }

    /**
     * @param $projectName
     *
     * @throws \Exception
     *
     * @return JsonResponse
     */
    public function getOwners($projectName)
    {
        if ($this->isId($projectName)) {
            $project = $this->projectService->get($projectName);
        } else {
            $project = $this->projectService->getByName($projectName);
        }

        if ($project == null) {
            throw new Exception("No project found with identifier $projectName.", 404);
        }

        $owners = $project->getContributors();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var User $owner */
        foreach ($owners as $owner) {
            $urlParams = array('userName' => $owner->getUsername());
            $data[] = array(
                'id' => $owner->getId(),
                'displayname' => $owner->getDisplayName(),
                'username' => $owner->getUsername(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.user.get', $urlParams),
                )
            );
        }
        return new JsonResponse($data);
    }

    /**
     * @param $projectName
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getContributors($projectName)
    {
        if ($this->isId($projectName)) {
            $project = $this->projectService->get($projectName);
        } else {
            $project = $this->projectService->getByName($projectName);
        }

        if ($project == null) {
            throw new Exception("No project found with identifier $projectName.", 404);
        }

        $contributors = $project->getContributors();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var User $contributor */
        foreach ($contributors as $contributor) {
            $urlParams = array('userName' => $contributor->getUsername());
            $data[] = array(
                'id' => $contributor->getId(),
                'displayname' => $contributor->getDisplayName(),
                'username' => $contributor->getUsername(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.user.get', $urlParams),
                )
            );
        }
        return new JsonResponse($data);
    }

    /**
     * @param $projectName
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getCategories($projectName)
    {
        // TODO Not implemented
        return new JsonResponse();
    }

    /**
     * @param $projectName
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getLanguages($projectName)
    {
        // TODO Not implemented
        return new JsonResponse();
    }
} 