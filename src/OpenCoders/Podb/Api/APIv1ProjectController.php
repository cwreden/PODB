<?php

namespace OpenCoders\Podb\Api;


use Exception;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Persistence\Repository\ProjectRepository;
use OpenCoders\Podb\REST\v1\BaseController;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class APIv1ProjectController extends BaseController
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var \OpenCoders\Podb\AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, ProjectRepository $projectRepository, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->projectRepository = $projectRepository;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $projects = $this->projectRepository->getAll();
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
            $project = $this->projectRepository->get($projectName);
        } else {
            $project = $this->projectRepository->getByName($projectName);
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
                'owner' => $urlGenerator->generate('rest.v1.json.user.get', array('userName' => $project->getOwner()->getUsername())),
                'default_language' => $urlGenerator->generate('rest.v1.json.language.get', array('locale' => $project->getDefaultLanguage()->getLocale())),
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getContributors($projectName)
    {
        if ($this->isId($projectName)) {
            $project = $this->projectRepository->get($projectName);
        } else {
            $project = $this->projectRepository->getByName($projectName);
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
        $project = $this->projectRepository->get($projectName);
        $categories = $project->getCategories();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        foreach ($categories as $category) {
            $urlParams = array('id' => $category->getId());
            $data[] = array(
                'id' => $category->getId(),
                'name' => $category->getName(),
                'description' => $category->getDescription(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.category.get', $urlParams),
                    'project' => $urlGenerator->generate('rest.v1.json.project.get', array('projectName' => $project->getName())),
                    'dataSets' => $urlGenerator->generate('rest.v1.json.category.dataSet.list', $urlParams)
                )
            );
        }

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
        $attributes['owner'] = $this->authenticationService->getCurrentUser();
        try {
            $project = $this->projectRepository->create($attributes);
            $this->projectRepository->flush();
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
            $project = $this->projectRepository->update($id, $attributes);
            $this->projectRepository->flush();
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

        $this->projectRepository->remove($id);
        $this->projectRepository->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
} 