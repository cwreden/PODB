<?php

namespace OpenCoders\Podb\Api;


use Doctrine\ORM\EntityManagerInterface;
use Exception;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Persistence\Entity\Domain;
use OpenCoders\Podb\Persistence\Repository\DomainRepository;
use OpenCoders\Podb\Persistence\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class APIv1DomainController
{
    /**
     * @var DomainRepository
     */
    private $domainRepository;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var AuthenticationService
     */
    private $authenticationService;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @param DomainRepository $domainRepository
     * @param AuthenticationService $authenticationService
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $entityManager
     * @param ProjectRepository $projectRepository
     */
    function __construct(
        DomainRepository $domainRepository,
        AuthenticationService $authenticationService,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        ProjectRepository $projectRepository
    )
    {
        $this->domainRepository = $domainRepository;
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->authenticationService = $authenticationService;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param $projectName
     * @return JsonResponse
     * @throws \OpenCoders\Podb\Exception\AuthenticationRequiredException
     */
    public function getList($projectName)
    {
        $this->authenticationService->ensureSession();
        $project = $this->projectRepository->getByName($projectName);
        $domains = $this->domainRepository->getAllForProject($project);

        $data = array();

        foreach ($domains as $domain) {
            $urlParams = array('projectName' => $projectName, 'domainName' => $domain->getName());

            $data[] = array(
                'id' => $domain->getId(),
                'name' => $domain->getName(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_DOMAIN_GET, $urlParams),
                    'project' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
                )
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @param $projectName
     * @param $domainName
     * @return JsonResponse
     * @throws \OpenCoders\Podb\Exception\AuthenticationRequiredException
     */
    public function get($projectName, $domainName)
    {
        $this->authenticationService->ensureSession();
        $project = $this->projectRepository->getByName($projectName);
        $domain = $this->domainRepository->getByName($project, $domainName);

        $urlParams = array('projectName' => $projectName, 'domainName' => $domain->getName());

        return new JsonResponse(array(
            'id' => $domain->getId(),
            'name' => $domain->getName(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_DOMAIN_GET, $urlParams),
                'project' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
            )
        ));
    }

    /**
     * @param $projectName
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @throws \OpenCoders\Podb\Exception\AuthenticationRequiredException
     */
    public function post($projectName, Request $request)
    {
        $this->authenticationService->ensureSession();
        try {
            $domain = new Domain();
            $domain->setName($request->get('name'));
            $domain->setDescription($request->get('description'));
            $domain->setProjectId($this->projectRepository->getByName($projectName));

            $this->entityManager->persist($domain);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array('projectName' => $projectName, 'domainName' => $domain->getName());

        return new JsonResponse(array(
            'id' => $domain->getId(),
            'name' => $domain->getName(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_DOMAIN_GET, $urlParams),
                'project' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
            )
        ));
    }

    /**
     * @param $projectName
     * @param $domainName
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @throws \OpenCoders\Podb\Exception\AuthenticationRequiredException
     */
    public function put($projectName, $domainName, Request $request)
    {
        $this->authenticationService->ensureSession();
        try {
            $project = $this->projectRepository->getByName($projectName);
            $domain = $this->domainRepository->getByName($project, $domainName);
            if ($request->request->has('name')) {
                $domain->setName($request->request->get('name'));
            }
            if ($request->request->has('description')) {
                $domain->setDescription($request->request->get('description'));
            }

            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array('projectName' => $projectName, 'domainName' => $domain->getName());

        return new JsonResponse(array(
            'id' => $domain->getId(),
            'name' => $domain->getName(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_DOMAIN_GET, $urlParams),
                'project' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
            )
        ));
    }

    /**
     * @param $projectName
     * @param $domainName
     * @return JsonResponse
     * @throws \OpenCoders\Podb\Exception\AuthenticationRequiredException
     */
    public function delete($projectName, $domainName)
    {
        $this->authenticationService->ensureSession();

        $project = $this->projectRepository->getByName($projectName);
        $domain = $this->domainRepository->getByName($project, $domainName);

        $this->entityManager->remove($domain);
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
