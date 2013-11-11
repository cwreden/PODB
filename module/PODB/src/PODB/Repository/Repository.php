<?php

namespace PODB\Repository;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class Repository implements ServiceLocatorAwareInterface {

    protected $entityClass = "";

    const DOCTRINE_ORM_ENTITY_MANAGER = 'Doctrine\ORM\EntityManager';

    /**
     * @var EntityRepository
     */
    private  $repository;
    /**
     * @var ServiceLocatorInterface
     */
    private  $serviceLocator;


    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        if ($this->repository) {
            return $this->repository;
        }
        $this->repository = $this->getEntityManager()->getRepository($this->entityClass);
        return $this->repository;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getServiceLocator()->get(self::DOCTRINE_ORM_ENTITY_MANAGER);
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $entity = $this->getRepository()->find($id);
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

}