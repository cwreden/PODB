<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Persistence\Entity\DataSet;

class DataSetService extends BaseEntityService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\DataSet';

    function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, self::ENTITY_NAME);
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
     * @return DataSet
     */
    public function create($attributes)
    {
        $dataSet = new DataSet();

        foreach ($attributes as $key => $value) {
            if ($key == 'category') {
                $dataSet->setCategory($value);
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
                $dataSet->setCategory($value);
            } else if ($key == 'msgId') {
                $dataSet->setMsgId($value);
            }
        }

        return $dataSet;
    }
} 