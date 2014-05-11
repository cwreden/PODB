<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class BaseEntityService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string EntityClassName (FQN)
     */
    private $entityName;

    function __construct(EntityManager $em, $entityName)
    {
        $this->em = $em;
        $this->entityName = $entityName;
    }

    /**
     * Returns the Singleton Instance of the EntityManger
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Returns the ProjectsRepository
     *
     * @return EntityRepository
     */
    protected function getRepository()
    {
        $repository = $this->getEntityManager()->getRepository($this->entityName);
        return $repository;
    }

    /**
     * Synchronize with database
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    /**
     * Delete
     *
     * @param $id
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $object = $em->getPartialReference($this->entityName, array('id' => $id));
        $em->remove($object);
    }
} 