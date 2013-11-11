<?php

namespace PODB\Repository;

use PODB\Entity\PODomain;

class PODomainRepository extends Repository
{
    protected $entityClass = 'PODB\Entity\PODomain';

    /**
     * @return PODomain[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param PODomain $entity
     * @return integer
     */
    public function create(PODomain $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity->getId();
    }

    /**
     * @param PODomain $entity
     */
    public function update(PODomain $entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $id
     * @return PODomain
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

}