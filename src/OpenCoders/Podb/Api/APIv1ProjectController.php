<?php

namespace OpenCoders\Podb\Api;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Persistence\Repository\LanguageRepository;
use OpenCoders\Podb\Persistence\Repository\ProjectRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class APIv1ProjectController
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var \OpenCoders\Podb\AuthenticationService
     */
    private $authenticationService;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @param ProjectRepository $projectRepository
     * @param AuthenticationService $authenticationService
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $entityManager
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        ProjectRepository $projectRepository,
        AuthenticationService $authenticationService,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        LanguageRepository $languageRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->authenticationService = $authenticationService;
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $projects = $this->projectRepository->getAll();
        $data = array();

        /** @var Project $project */
        foreach ($projects as $project) {
            $urlParams = array('projectName' => $project->getName());
            $data[] = array(
                'id' => $project->getId(),
                'name' => $project->getName(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
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
        $urlParams = array('projectName' => $project->getName());

        $defaultLanguageURI = null;
        if ($project->getDefaultLanguage() instanceof Language) {
            $defaultLanguageURI = $this->urlGenerator->generate(
                ApiURIs::V1_LANGUAGE_GET,
                array('locale' => $project->getDefaultLanguage()->getLocale())
            );
        }
        return new JsonResponse(array(
            'id' => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
            'private' => $project->getPrivate(),
            'blog' => $project->getUrl(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
                'owner' => $this->urlGenerator->generate(
                    ApiURIs::V1_USER_GET,
                    array('userName' => $project->getOwner()->getUsername())
                ),
                'default_language' => $defaultLanguageURI,
                'contributors' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_CONTRIBUTOR_LIST, $urlParams),
                'languages' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_LANGUAGE_LIST, $urlParams),
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
        $data = array();

        /** @var User $contributor */
        foreach ($contributors as $contributor) {
            $urlParams = array('userName' => $contributor->getUsername());
            $data[] = array(
                'id' => $contributor->getId(),
                'displayName' => $contributor->getDisplayName(),
                'username' => $contributor->getUsername(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_USER_GET, $urlParams),
                )
            );
        }
        return new JsonResponse($data);
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
        try {
            $project = new Project();

            $project->setName($request->get('name'));
            $project->setDescription($request->get('description'));
            $project->setPrivate(false);// TODO not implemented
            $project->setUrl($request->get('blog'));
            $project->setOwner($this->authenticationService->getCurrentUser());
//            $project->setContributors($value); // TODO extract as own api endpoint (add/remove)
            $project->setDefaultLanguage($this->languageRepository->get($request->get('defaultLanguage')));

            $this->entityManager->persist($project);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array('projectName' => $project->getName());

        return new JsonResponse(array(
            'id' => $project->getId(),
            'name' => $project->getName(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
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

        try {
            $project = $this->projectRepository->get($id);

//            $project->setName($request->get('name'));
            if ($request->request->has('description')) {
                $project->setDescription($request->get('description'));
            }
            if ($request->request->has('private')) {
                $project->setPrivate(false);// TODO not implemented
            }
            if ($request->request->has('blog')) {
                $project->setUrl($request->get('blog'));
            }
            if ($request->request->has('defaultLanguage')) {
                $project->setDefaultLanguage($this->languageRepository->get($request->request->get('defaultLanguage')));
            }

            $this->entityManager->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlParams = array('projectName' => $project->getName());

        return new JsonResponse(array(
            'id' => $project->getId(),
            'name' => $project->getName(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
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

        $project = $this->projectRepository->get($id);

        $this->entityManager->remove($project);
        $this->entityManager->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }

    /**
     * Returns true, if $value is an integer
     *
     * @param $value
     * @return bool
     */
    protected function isId($value)
    {
        return isset($value) && intval($value) != 0;
    }
}
