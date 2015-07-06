<?php

namespace OpenCoders\Podb\Api;


use Doctrine\ORM\EntityManagerInterface;
use Exception;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\MissingParameterException;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\Translation;
use OpenCoders\Podb\Persistence\Repository\LanguageRepository;
use OpenCoders\Podb\Persistence\Repository\MessageRepository;
use OpenCoders\Podb\Persistence\Repository\ProjectRepository;
use OpenCoders\Podb\Persistence\Repository\TranslationRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class APIv1TranslationController
{
    /**
     * @var TranslationRepository
     */
    private $translationRepository;

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
     * @var MessageRepository
     */
    private $messageRepository;
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @param TranslationRepository $translationRepository
     * @param AuthenticationService $authenticationService
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $entityManager
     * @param ProjectRepository $projectRepository
     * @param MessageRepository $messageRepository
     * @param LanguageRepository $languageRepository
     */
    function __construct(
        TranslationRepository $translationRepository,
        AuthenticationService $authenticationService,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        ProjectRepository $projectRepository,
        MessageRepository $messageRepository,
        LanguageRepository $languageRepository
    )
    {
        $this->translationRepository = $translationRepository;
        $this->authenticationService = $authenticationService;
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->projectRepository = $projectRepository;
        $this->messageRepository = $messageRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param $projectName
     * @param $locale
     * @return JsonResponse
     */
    public function getList($projectName, $locale)
    {
        $project = $this->projectRepository->getByName($projectName);
        if (!$project instanceof Project) {
            throw new NotFoundHttpException(sprintf('Project with name %s not found.', $projectName));
        }

        $language = $this->languageRepository->getByLocale($locale);
        if (!$language instanceof Language) {
            throw new NotFoundHttpException(sprintf('Language with locale %d not found.', $locale));
        }

        $translations = $this->translationRepository->getListByProjectAndLanguage($project, $language);
        $data = array();

        /** @var Translation $translation */
        foreach ($translations as $translation) {
            $urlParams = array(
                'id' => $translation->getMessage()->getId(),
            );
            $data[] = array(
                'id' => $translation->getId(),
                'msgStr' => $translation->getMsgStr(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_MESSAGE_TRANSLATION_GET, $urlParams),
                )
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function get($id)
    {
        $translation = $this->translationRepository->get($id);

        if ($translation == null) {
            throw new Exception("No translation found with identifier $id.", 404);
        }

        $urlParams = array(
            'id' => $translation->getId()
        );
        $languageParams = array(
            'locale' => $translation->getLanguage()->getLocale()
        );
        $message = $translation->getMessage();
        $messageParams = array(
            'projectName' => $message->getProject()->getName(),
            'id' => $message->getId()
        );

        return new JsonResponse(array(
            'id' => $translation->getId(),
            'msgStr' => $translation->getMsgStr(),
            'msgStr1' => $translation->getMsgStr1(),
            'msgStr2' => $translation->getMsgStr2(),
            'fuzzy' => $translation->getFuzzy(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_MESSAGE_TRANSLATION_GET, $urlParams),
                'language' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_GET, $languageParams),
                'message' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_MESSAGE_GET, $messageParams)
            )
        ));
    }

    /**
     * Creates a new translation object by given data
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return JsonResponse
     * @throws Exception
     * @throws \OpenCoders\Podb\Exception\AuthenticationRequiredException
     */
    public function post(Request $request)
    {
        $this->authenticationService->ensureSession();
        try {
            $locale = '';

            if (!$request->request->has('messageId')) {
                throw new MissingParameterException('messageId');
            }
            if (!$request->request->has('languageId')) {
                throw new MissingParameterException('languageId');
            }
            if (!$request->request->has('msgStr')) {
                throw new MissingParameterException('msgStr');
            }

            $message = $this->messageRepository->get($request->request->get('messageId'));
            $language = $this->languageRepository->getByLocale($request->request->get('languageId'));

            $translation = new Translation();
            $translation->setMessage($message);
            $translation->setLanguage($language);
            $translation->setFuzzy((bool)$request->request->get('fuzzy'));
            $translation->setMsgStr($request->request->get('msgStr'));
            if ($request->request->has('msgStr1')) {
                $translation->setMsgStr1($request->request->get('msgStr1'));
            }
            if ($request->request->has('msgStr2')) {
                $translation->setMsgStr2($request->request->get('msgStr2'));
            }


            $this->entityManager->persist($translation);
            $this->entityManager->flush();

        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array(
            'id' => $translation->getId()
        );
        $languageParams = array(
            'locale' => $locale
        );
        $messageParams = array(
            'projectName' => $message->getProject()->getName(),
            'id' => $translation->getMessage()->getId()
        );

        return new JsonResponse(array(
            'id' => $translation->getId(),
            'msgStr' => $translation->getMsgStr(),
            'msgStr1' => $translation->getMsgStr1(),
            'msgStr2' => $translation->getMsgStr2(),
            'fuzzy' => $translation->getFuzzy(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_MESSAGE_TRANSLATION_GET, $urlParams),
                'language' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_GET, $languageParams),
                'message' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_MESSAGE_GET, $messageParams)
            )
        ));
    }

    /**
     * Updates a translation Object
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
            $translation = $this->translationRepository->get($id);

            if ($request->request->has('messageId')) {
                $translation->setMessage($this->messageRepository->get($request->request->get('messageId')));
            }
            if ($request->request->has('languageId')) {
                $translation->setLanguage($this->languageRepository->get($request->request->get('languageId')));
            }
            if ($request->request->has('fuzzy')) {
                $translation->setFuzzy((bool)$request->request->get('fuzzy'));
            }
            if ($request->request->has('msgStr')) {
                $translation->setMsgStr($request->request->get('msgStr'));
            }
            if ($request->request->has('msgStr1')) {
                $translation->setMsgStr1($request->request->get('msgStr1'));
            }
            if ($request->request->has('msgStr2')) {
                $translation->setMsgStr2($request->request->get('msgStr2'));
            }

            $this->translationRepository->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlParams = array(
            'id' => $translation->getId()
        );
        $languageParams = array(
            'locale' => $translation->getLanguage()->getLocale()
        );
        $messageParams = array(
            'projectName' => $translation->getMessage()->getProject()->getName(),
            'id' => $translation->getMessage()->getId()
        );

        return new JsonResponse(array(
            'id' => $translation->getId(),
            'msgStr' => $translation->getMsgStr(),
            'msgStr1' => $translation->getMsgStr1(),
            'msgStr2' => $translation->getMsgStr2(),
            'fuzzy' => $translation->getFuzzy(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_MESSAGE_TRANSLATION_GET, $urlParams),
                'language' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_GET, $languageParams),
                'message' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_MESSAGE_GET, $messageParams)
            )
        ));
    }

    /**
     * Delete Translation by ID
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

        $translation = $this->translationRepository->get($id);

        $this->translationRepository->remove($translation);
        $this->translationRepository->flush();

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