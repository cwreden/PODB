<?php

namespace OpenCoders\Podb\Api;


use Doctrine\ORM\EntityManagerInterface;
use Exception;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Persistence\Repository\LanguageRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class APIv1LanguageController
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

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
     * @param LanguageRepository $languageRepository
     * @param AuthenticationService $authenticationService
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $entityManager
     */
    function __construct(
        LanguageRepository $languageRepository,
        AuthenticationService $authenticationService,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager
    )
    {
        $this->languageRepository = $languageRepository;
        $this->authenticationService = $authenticationService;
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $languages = $this->languageRepository->getAll();
        $data = array();

        foreach ($languages as $language) {
            $urlParams = array('locale' => $language->getLocale());
            $data[] = array(
                'id' => $language->getId(),
                'name' => $language->getLabel(),
                'locale' => $language->getLocale(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_GET, $urlParams),
                )
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @param $locale
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function get($locale)
    {
        if ($this->isId($locale)) {
            $language = $this->languageRepository->get($locale);
        } else {
            $language = $this->languageRepository->getByLocale($locale);
        }

        if ($language == null) {
            throw new Exception("No language found with identifier $locale.", 404);
        }
        $urlParams = array('locale' => $language->getLocale());

        return new JsonResponse(array(
            'id' => $language->getId(),
            'name' => $language->getLabel(),
            'locale' => $language->getLocale(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_GET, $urlParams),
                'supporter' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_SUPPORTER_LIST, $urlParams),
            )
        ));
    }

    /**
     * @param $locale
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function getSupporters($locale)
    {
        if ($this->isId($locale)) {
            $language = $this->languageRepository->get($locale);
        } else {
            $language = $this->languageRepository->getByLocale($locale);
        }

        if ($language == null) {
            throw new Exception("No language found with identifier $locale.", 404);
        }

        $supporters = $language->getSupportedBy();
        $data = array();

        /** @var User $supporter */
        foreach ($supporters as $supporter) {
            $urlParams = array('userName' => $supporter->getUsername());
            $data[] = array(
                'id' => $supporter->getId(),
                'displayName' => $supporter->getDisplayName(),
                'username' => $supporter->getUsername(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_USER_GET, $urlParams),
                )
            );
        }

        return new JsonResponse($data);
    }

    /**
     * Creates a new language object by given data
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
            $language = new Language();
            $language->setLabel($request->get('name'));
            $language->setLabel($request->get('locale'));

            $this->entityManager->persist($language);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array('locale' => $language->getLocale());

        return new JsonResponse(array(
            'id' => $language->getId(),
            'name' => $language->getLabel(),
            'locale' => $language->getLocale(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_GET, $urlParams),
                'supporter' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_SUPPORTER_LIST, $urlParams),
            )
        ));
    }

    /**
     * Updates a language Object
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
            $language = $this->languageRepository->get($id);
            $label = $request->get('name');
            if (!empty($label)) {
                $language->setLabel($label);
            }
            $locale = $request->get('locale');
            if (!empty($locale)) {
                $language->setLocale($locale);
            }

            $this->entityManager->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlParams = array('locale' => $language->getLocale());

        return new JsonResponse(array(
            'id' => $language->getId(),
            'name' => $language->getLabel(),
            'locale' => $language->getLocale(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_GET, $urlParams),
                'supporter' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_SUPPORTER_LIST, $urlParams),
            )
        ));
    }

    /**
     * Delete Language by ID
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

        $language = $this->languageRepository->get($id);

        $this->entityManager->remove($language);
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