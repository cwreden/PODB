<?php

namespace OpenCoders\Podb\REST\v1\json;


use Exception;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Translation;
use OpenCoders\Podb\Persistence\Repository\TranslationRepository;
use OpenCoders\Podb\REST\v1\BaseController;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TranslationController extends BaseController
{
    /**
     * @var TranslationRepository
     */
    private $translationRepository;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, TranslationRepository $translationRepository, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->translationRepository = $translationRepository;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $translations = $this->translationRepository->getAll();
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
        $translation = $this->translationRepository->get($id);

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
                'dataSet' => $urlGenerator->generate('rest.v1.json.dataSet.get', array('id' => $translation->getMessage()->getId()))
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
            $translation = $this->translationRepository->create($attributes);
            $this->translationRepository->flush();
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
            $translation = $this->translationRepository->update($id, $attributes);
            $this->translationRepository->flush();
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

        $this->translationRepository->remove($id);
        $this->translationRepository->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
}