<?php

namespace OpenCoders\Podb\REST\v1\json;


use Exception;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\REST\v1\BaseController;
use OpenCoders\Podb\Service\AuthenticationService;
use OpenCoders\Podb\Service\LanguageService;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends BaseController
{
    /**
     * @var LanguageService
     */
    private $languageService;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, LanguageService $languageService, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->languageService = $languageService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $languages = $this->languageService->getAll();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var Language $language */
        foreach ($languages as $language) {
            $urlParams = array('locale' => $language->getLocale());
            $data[] = array(
                'id' => $language->getId(),
                'name' => $language->getLabel(),
                'locale' => $language->getLocale(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.language.get', $urlParams),
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
            $language = $this->languageService->get($locale);
        } else {
            $language = $this->languageService->getByLocale($locale);
        }

        if ($language == null) {
            throw new Exception("No language found with identifier $locale.", 404);
        }
        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('locale' => $language->getLocale());

        return new JsonResponse(array(
            'id' => $language->getId(),
            'name' => $language->getLabel(),
            'locale' => $language->getLocale(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.language.get', $urlParams),
                'supporter' => $urlGenerator->generate('rest.v1.json.language.supporter.list', $urlParams),
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
            $language = $this->languageService->get($locale);
        } else {
            $language = $this->languageService->getByLocale($locale);
        }

        if ($language == null) {
            throw new Exception("No language found with identifier $locale.", 404);
        }

        $supporters = $language->getSupportedBy();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var User $supporter */
        foreach ($supporters as $supporter) {
            $urlParams = array('userName' => $supporter->getUsername());
            $data[] = array(
                'id' => $supporter->getId(),
                'displayname' => $supporter->getDisplayName(),
                'username' => $supporter->getUsername(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.user.get', $urlParams),
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
        $attributes = $request->request->all();
        try {
            $language = $this->languageService->create($attributes);
            $this->languageService->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array('locale' => $language->getLocale());
        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $language->getId(),
            'name' => $language->getLabel(),
            'locale' => $language->getLocale(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.language.get', $urlParams),
                'supporter' => $urlGenerator->generate('rest.v1.json.language.supporter.list', $urlParams),
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

        $attributes = $request->request->all();
        try {
            $language = $this->languageService->update($id, $attributes);
            $this->languageService->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlParams = array('locale' => $language->getLocale());
        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $language->getId(),
            'name' => $language->getLabel(),
            'locale' => $language->getLocale(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.language.get', $urlParams),
                'supporter' => $urlGenerator->generate('rest.v1.json.language.supporter.list', $urlParams),
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

        $this->languageService->remove($id);
        $this->languageService->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
}