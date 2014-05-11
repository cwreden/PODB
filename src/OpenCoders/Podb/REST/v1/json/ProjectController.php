<?php

namespace OpenCoders\Podb\REST\v1\json;


use Exception;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\REST\v1\BaseController;
use OpenCoders\Podb\Service\AuthenticationService;
use OpenCoders\Podb\Service\ProjectService;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends BaseController
{
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, ProjectService $projectService, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->projectService = $projectService;
        $this->authenticationService = $authenticationService;
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
    public function getOwner($projectName)
    {
        if ($this->isId($projectName)) {
            $project = $this->projectService->get($projectName);
        } else {
            $project = $this->projectService->getByName($projectName);
        }

        if ($project == null) {
            throw new Exception("No project found with identifier $projectName.", 404);
        }

        $owner = $project->getOwner();
        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('userName' => $owner->getUsername());

        return new JsonResponse(array(
            'id' => $owner->getId(),
            'displayname' => $owner->getDisplayName(),
            'username' => $owner->getUsername(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.user.get', $urlParams),
            )
        ));
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

    /**
     * Creates a new user object by given data
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function post(Request $request)
    {
        $this->authenticationService->ensureSession();
        $attributes = $request->request->all();
        try {
            $project = $this->projectService->create($attributes);
            $this->projectService->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array('projectName' => $project->getName());
        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $project->getId(),
            'name' => $project->getName(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.project.get', $urlParams),
            )
        ));
    }

    /**
     * Updates a User Object
     *
     * @param int $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @throws \Exception
     *
     * @return bool
     */
    public function put($id, Request $request)
    {
        $this->authenticationService->ensureSession();
        if (!$this->isId($id)) {
            throw new Exception('Invalid ID ' . $id, 400);
        }

        $attributes = $request->request->all();
        try {
            $project = $this->projectService->update($id, $attributes);
            $this->projectService->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlParams = array('projectName' => $project->getName());
        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $project->getId(),
            'name' => $project->getName(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.project.get', $urlParams),
            )
        ));
    }

    /**
     * Delete Project by ID
     *
     * @param int $id
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function delete($id)
    {
        $this->authenticationService->ensureSession();
        if (!$this->isId($id)) {
            throw new Exception('Invalid ID ' . $id, 400);
        }

        $this->projectService->remove($id);
        $this->projectService->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
} 