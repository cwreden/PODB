<?php

namespace PODB\Repository;

use PODB\Entity\PODataset;

class PODatasetRepository extends Repository
{
    protected $entityClass = 'PODB\Entity\PODataset';

    /**
     * @return PODataset[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param PODataset $entity
     * @return integer
     */
    public function create(PODataset $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity->getId();
    }

    /**
     * @param PODataset $entity
     */
    public function update(PODataset $entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $id
     * @return PODataset
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

}