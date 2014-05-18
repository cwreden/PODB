<?php

namespace OpenCoders\Podb\REST\v1\json;


use Doctrine\ORM\EntityNotFoundException;
use Exception;
use OpenCoders\Podb\Persistence\Entity\Category;
use OpenCoders\Podb\REST\v1\BaseController;
use OpenCoders\Podb\Service\AuthenticationService;
use OpenCoders\Podb\Service\CategoryService;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends BaseController
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, CategoryService $categoryService, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->categoryService = $categoryService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $categories = $this->categoryService->getAll();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var Category $category */
        foreach ($categories as $category) {
            $urlParams = array('id' => $category->getId());
            $data[] = array(
                'id' => $category->getId(),
                'name' => $category->getName(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.category.get', $urlParams),
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
        if (!$this->isId($id)) {
            throw new \InvalidArgumentException('Invalid ID.');
        }
        $category = $this->categoryService->get($id);

        if ($category === null) {
            throw new EntityNotFoundException("No category found with identifier $id.", 404);
        }
        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('id' => $category->getId());

        return new JsonResponse(array(
            'id' => $category->getId(),
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.category.get', $urlParams),
                'project' => $urlGenerator->generate('rest.v1.json.project.get', array('projectName' => $category->getProject()->getName())),
                'dataSets' => $urlGenerator->generate('rest.v1.json.category.dataSet.list', $urlParams)
            )
        ));
    }

    /**
     * @param $id
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \InvalidArgumentException
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDataSets($id)
    {
        if (!$this->isId($id)) {
            throw new \InvalidArgumentException('Invalid ID');
        }
        $category = $this->categoryService->get($id);
        if ($category === null) {
            throw new EntityNotFoundException();
        }
        $dataSets = $category->getDataSets();

        $urlGenerator = $this->getUrlGenerator();
        $categoryUrlParams = array('id' => $category->getId());

        $result = array();
        foreach ($dataSets as $dataSet) {
            $result[] = array(
                'id' => $dataSet->getId(),
                'msgId' => $dataSet->getMsgId(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.dataSet.get', array('id' => $dataSet->getId())),
                    'category' => $urlGenerator->generate('rest.v1.json.category.get', $categoryUrlParams)
                )
            );
        }

        return new JsonResponse($result);
    }

    /**
     * Creates a new category object by given data
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
            $category = $this->categoryService->create($attributes);
            $this->categoryService->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $category->getId(),
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.category.get', array('id' => $category->getId())),
                'project' => $urlGenerator->generate('rest.v1.json.project.get', array('projectName' => $category->getProject()->getName()))
            )
        ));
    }

    /**
     * Updates a category Object
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
            $category = $this->categoryService->update($id, $attributes);
            $this->categoryService->flush();
        } catch (Exception $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlGenerator = $this->getUrlGenerator();

        return new JsonResponse(array(
            'id' => $category->getId(),
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.category.get', array('id' => $category->getId())),
                'project' => $urlGenerator->generate('rest.v1.json.project.get', array('projectName' => $category->getProject()->getName()))
            )
        ));
    }

    /**
     * Delete Category by ID
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
            throw new \InvalidArgumentException('Invalid ID ' . $id, 400);
        }

        $this->categoryService->remove($id);
        $this->categoryService->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }
} 