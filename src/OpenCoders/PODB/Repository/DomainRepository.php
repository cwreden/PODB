<?php

namespace OpenCoders\PODB\Repository;

use OpenCoders\PODB\Entity\Domain;

class DomainRepository extends Repository
{
    protected $entityClass = 'PODB\Entity\Domain';

    /**
     * @return Domain[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param Domain $entity
     * @return integer
     */
    public function create(Domain $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity->getId();
    }

    /**
     * @param Domain $entity
     */
    public function update(Domain $entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $id
     * @return Domain
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }
}