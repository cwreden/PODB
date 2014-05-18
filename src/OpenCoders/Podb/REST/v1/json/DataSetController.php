<?php

namespace OpenCoders\Podb\REST\v1\json;


use Doctrine\ORM\EntityNotFoundException;
use Exception;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\DataSet;
use OpenCoders\Podb\REST\v1\BaseController;
use OpenCoders\Podb\Service\AuthenticationService;
use OpenCoders\Podb\Service\DataSetService;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DataSetController extends BaseController
{
    /**
     * @var DataSetService
     */
    private $dataSetService;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, DataSetService $dataSetService, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->authenticationService = $authenticationService;
        $this->dataSetService = $dataSetService;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $dataSets = $this->dataSetService->getAll();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var DataSet $dataSet */
        foreach ($dataSets as $dataSet) {
            $urlParams = array('id' => $dataSet->getId());
            $data[] = array(
                'id' => $dataSet->getId(),
                'msgId' => $dataSet->getMsgId(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.dataSet.get', $urlParams),
                    'category' => $urlGenerator->generate('rest.v1.json.category.get', array('id' => $dataSet->getCategory()->getId()))
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
        $dataSet = $this->dataSetService->get($id);

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
                'category' => $urlGenerator->generate('rest.v1.json.category.get', array('id' => $dataSet->getCategory())),
            )
        ));
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
            $dataSet = $this->dataSetService->create($attributes);
            $this->dataSetService->flush();
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
            $dataSet = $this->dataSetService->update($id, $attributes);
            $this->dataSetService->flush();
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

        $this->dataSetService->remove($id);
        $this->dataSetService->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
}