<?php

namespace OpenCoders\PODB\Repository;

use OpenCoders\PODB\helper\Doctrine;

class Repository
{

    /**
     * @var string
     */
    protected $entityClass = "";

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        if ($this->repository) {
            return $this->repository;
        }

        return $this->repository = $this->getEntityManager()->getRepository($this->entityClass);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return Doctrine::getEntityManager();
    }
}