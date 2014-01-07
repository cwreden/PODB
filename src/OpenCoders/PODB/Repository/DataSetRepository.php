<?php

namespace OpenCoders\PODB\Repository;

use OpenCoders\PODB\Entity\DataSet;

class DataSetRepository extends Repository
{
    protected $entityClass = 'PODB\Entity\DataSet';

    /**
     * @return DataSet[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param DataSet $entity
     * @return integer
     */
    public function create(DataSet $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity->getId();
    }

    /**
     * @param DataSet $entity
     */
    public function update(DataSet $entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $id
     * @return DataSet
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }
}