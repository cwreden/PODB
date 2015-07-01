<?php

namespace OpenCoders\Podb\Api;


use Doctrine\ORM\EntityManagerInterface;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Persistence\Entity\Message;
use OpenCoders\Podb\Persistence\Repository\DomainRepository;
use OpenCoders\Podb\Persistence\Repository\MessageRepository;
use OpenCoders\Podb\Persistence\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class APIv1MessageController
{
    /**
     * @var MessageRepository
     */
    private $messageRepository;
    /**
     * @var AuthenticationService
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
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var DomainRepository
     */
    private $domainRepository;

    /**
     * @param MessageRepository $messageRepository
     * @param AuthenticationService $authenticationService
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $entityManager
     * @param ProjectRepository $projectRepository
     * @param DomainRepository $domainRepository
     */
    function __construct(
        MessageRepository $messageRepository,
        AuthenticationService $authenticationService,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        ProjectRepository $projectRepository,
        DomainRepository $domainRepository
    )
    {
        $this->messageRepository = $messageRepository;
        $this->authenticationService = $authenticationService;
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->projectRepository = $projectRepository;
        $this->domainRepository = $domainRepository;
    }

    /**
     * @param $projectName
     * @param Request $request
     * @return JsonResponse
     */
    public function getList($projectName, Request $request)
    {
        $project = $this->projectRepository->getByName($projectName);
        $domainId = null;
        if ($request->query->has('domainId')) {
            $domainId = $request->query->get('domainId');
        }
        $messages = $this->messageRepository->getListByProject($project, $domainId);

        $data = array();

        foreach ($messages as $message) {
            $data[] = array(
                'id' => $message->getId(),
                'msgId' => $message->getMsgId(),
                '_links' => array()
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @param $projectName
     * @param Request $request
     * @return JsonResponse
     */
    public function post($projectName, Request $request)
    {
        $project = $this->projectRepository->getByName($projectName);

        $message = new Message();
        $message->setProject($project);
        $message->setMsgId($request->request->get('msgId'));
        if ($request->request->has('domainId')) {
            $domain = $this->domainRepository->get($request->request->get('domainId'));
            $message->setDomain($domain);
        }

        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return new JsonResponse(array(
            'id' => $message->getId(),
            'msgId' => $message->getMsgId(),
            '_links' => array()
        ));
    }

    /**
     * @param $projectName
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function put($projectName, $id, Request $request)
    {
        $project = $this->projectRepository->getByName($projectName);
        $message = $this->messageRepository->get($id);

        if ($message->getProject()->getId() !== $project->getId()) {
            throw new NotFoundHttpException(sprintf('Message with ID: %d for project %s not found.', $id, $projectName));
        }

        if ($request->request->has('msgId')) {
            $message->setMsgId($request->request->get('msgId'));
        }
        if ($request->request->has('domainId')) {
            $domain = $this->domainRepository->get($request->request->get('domainId'));
            $message->setDomain($domain);
        }

        $this->entityManager->flush();

        return new JsonResponse(array(
            'id' => $message->getId(),
            'msgId' => $message->getMsgId(),
            '_links' => array()
        ));
    }

    /**
     * @param $projectName
     * @param $id
     * @return JsonResponse
     */
    public function delete($projectName, $id)
    {
        $project = $this->projectRepository->getByName($projectName);
        $message = $this->messageRepository->get($id);

        if ($message->getProject()->getId() !== $project->getId()) {
            throw new NotFoundHttpException(sprintf('Message with ID: %d for project %s not found.', $id, $projectName));
        }

        $this->entityManager->remove($message);
        $this->entityManager->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
}
