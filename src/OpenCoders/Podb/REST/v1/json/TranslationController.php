<?php

namespace OpenCoders\Podb\REST\v1\json;


use Exception;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Translation;
use OpenCoders\Podb\REST\v1\BaseController;
use OpenCoders\Podb\Service\AuthenticationService;
use OpenCoders\Podb\Service\TranslationService;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TranslationController extends BaseController
{
    /**
     * @var
     */
    private $translationService;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, TranslationService $translationService, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->translationService = $translationService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $translations = $this->translationService->getAll();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var Translation $translation */
        foreach ($translations as $translation) {
            $urlParams = array('id' => $translation->getId());
            $data[] = array(
                'id' => $translation->getId(),
                'msgStr' => $translation->getMsgStr(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.translation.get', $urlParams),
                )
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @param $id
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function get($id)
    {
        $translation = $this->translationService->get($id);

        if ($translation == null) {
            throw new Exception("No translation found with identifier $id.", 404);
        }
        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('id' => $translation->getId());

        return new JsonResponse(array(
            'id' => $translation->getId(),
            'msgStr' => $translation->getMsgStr(),
            'msgStr1' => $translation->getMsgStr1(),
            'msgStr2' => $translation->getMsgStr2(),
            'fuzzy' => $translation->getFuzzy(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.translation.get', $urlParams),
                'language' => $urlGenerator->generate('rest.v1.json.language.get', array('locale' => $translation->getLanguage()->getLocale())),
                'dataSet' => $urlGenerator->generate('rest.v1.json.dataSet.get', array('id' => $translation->getDataSet()->getId()))
            )
        ));
    }

    /**
     * Creates a new translation object by given data
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
            $translation = $this->translationService->create($attributes);
            $this->translationService->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array('id' => $translation->getId());
        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $translation->getId(),
            'msgStr' => $translation->getMsgStr(),
            'msgStr1' => $translation->getMsgStr1(),
            'msgStr2' => $translation->getMsgStr2(),
            'fuzzy' => $translation->getFuzzy(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.translation.get', $urlParams),
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

        $attributes = $request->request->all();
        try {
            $translation = $this->translationService->update($id, $attributes);
            $this->translationService->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlParams = array('id' => $translation->getId());
        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $translation->getId(),
            'msgStr' => $translation->getMsgStr(),
            'msgStr1' => $translation->getMsgStr1(),
            'msgStr2' => $translation->getMsgStr2(),
            'fuzzy' => $translation->getFuzzy(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.translation.get', $urlParams),
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

        $this->translationService->remove($id);
        $this->translationService->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
}