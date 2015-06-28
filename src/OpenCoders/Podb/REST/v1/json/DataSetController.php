<?php

namespace OpenCoders\Podb\REST\v1\json;


use Doctrine\ORM\EntityNotFoundException;
use Exception;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\DataSet;
use OpenCoders\Podb\Persistence\Entity\Translation;
use OpenCoders\Podb\Persistence\Repository\MessageRepository;
use OpenCoders\Podb\REST\v1\BaseController;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DataSetController
 * @package OpenCoders\Podb\REST\v1\json
 * @deprecated
 * TODO refactor to message controller
 */
class DataSetController extends BaseController
{
    /**
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * @var \OpenCoders\Podb\AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, MessageRepository $messageRepository, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->authenticationService = $authenticationService;
        $this->messageRepository = $messageRepository;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $dataSets = $this->messageRepository->getAll();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var DataSet $dataSet */
        foreach ($dataSets as $dataSet) {
            $urlParams = array('id' => $dataSet->getId());
            $data[] = array(
                'id' => $dataSet->getId(),
                'msgId' => $dataSet->getMsgId(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.dataSet.get', $urlParams)
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
        $dataSet = $this->messageRepository->get($id);

        if ($dataSet == null) {
            throw new EntityNotFoundException("No dataSet found with identifier $id.", 404);
        }
        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('id' => $dataSet->getId());

        return new JsonResponse(array(
            'id' => $dataSet->getId(),
            'msgId' => $dataSet->getMsgId(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.dataSet.get', $urlParams),
                'category' => $urlGenerator->generate('rest.v1.json.category.get', array('id' => $dataSet->getCategory()->getId())),
                'translations' => $urlGenerator->generate('rest.v1.json.dataSet.translation.list', $urlParams)
            )
        ));
    }

    /**
     * @param $id
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTranslations($id)
    {
        $dataSet = $this->messageRepository->get($id);

        if ($dataSet == null) {
            throw new EntityNotFoundException("No dataSet found with identifier $id.", 404);
        }
        $urlGenerator = $this->getUrlGenerator();

        $result = array();
        /** @var Translation $translation */
        foreach ($dataSet->getTranslations() as $translation) {
            $result[] = array(
                'id' => $translation->getId(),
                'msgStr' => $translation->getMsgStr(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.translation.get', array('id' => $translation->getId())),
                )
            );
        }

        return new JsonResponse($result);
    }

    /**
     * Creates a new dataSet object by given data
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
            $dataSet = $this->messageRepository->create($attributes);
            $this->messageRepository->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $dataSet->getId(),
            'msgId' => $dataSet->getMsgId(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.dataSet.get', array('id' => $dataSet->getId())),
                'category' => $urlGenerator->generate('rest.v1.json.category.get', array('id' => $dataSet->getCategory())),
            )
        ));
    }

    /**
     * Updates a dataSet Object
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
            throw new \InvalidArgumentException('Invalid ID ' . $id, 400);
        }

        $attributes = $request->request->all();
        try {
            $dataSet = $this->messageRepository->update($id, $attributes);
            $this->messageRepository->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $dataSet->getId(),
            'msgId' => $dataSet->getMsgId(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.dataSet.get', array('id' => $dataSet->getId())),
                'category' => $urlGenerator->generate('rest.v1.json.category.get', array('id' => $dataSet->getCategory())),
            )
        ));
    }

    /**
     * Delete DataSet by ID
     *
     * @param int $id
     *
     * @throws \InvalidArgumentException
     * @return JsonResponse
     */
    public function delete($id)
    {
        $this->authenticationService->ensureSession();
        if (!$this->isId($id)) {
            throw new \InvalidArgumentException('Invalid ID ' . $id, 400);
        }

        $this->messageRepository->remove($id);
        $this->messageRepository->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
}