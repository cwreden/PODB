<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Exception\MissingParameterException;
use OpenCoders\Podb\Persistence\Entity\DataSet;

class DataSetService extends BaseEntityService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\DataSet';

    /**
     * @var CategoryService
     */
    private $categoryService;

    function __construct(EntityManager $entityManager, CategoryService $categoryService)
    {
        parent::__construct($entityManager, self::ENTITY_NAME);
        $this->categoryService = $categoryService;
    }

    /**
     * @return DataSet[]
     */
    public function getAll()
    {
        $repository = $this->getRepository();
        return $repository->findAll();
    }

    /**
     * @param $id
     * @return null|DataSet
     */
    public function get($id)
    {
        $repository = $this->getRepository();
        return $repository->find($id);
    }

    /**
     * @param $attributes
     * @throws \OpenCoders\Podb\Exception\MissingParameterException
     * @return DataSet
     */
    public function create($attributes)
    {
        $dataSet = new DataSet();

        if (!isset($attributes['category'])) {
            throw new MissingParameterException('category');
        } elseif (!isset($attributes['msgId'])) {
            throw new MissingParameterException('msgId');
        }

        foreach ($attributes as $key => $value) {
            if ($key == 'category') {
                $dataSet->setCategory($this->categoryService->get($value));
            } else if ($key == 'msgId') {
                $dataSet->setMsgId($value);
            }
        }

        $em = $this->getEntityManager();
        $em->persist($dataSet);

        return $dataSet;
    }

    /**
     * Update a DataSet
     *
     * @param $id
     * @param $attributes
     * @return null|DataSet
     */
    public function update($id, $attributes)
    {
        $dataSet = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key == 'category') {
                $dataSet->setCategory($this->categoryService->get($value));
            } else if ($key == 'msgId') {
                $dataSet->setMsgId($value);
            }
        }

        return $dataSet;
    }
} 