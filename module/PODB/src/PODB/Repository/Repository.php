<?php

namespace PODB\Repository;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class Repository implements ServiceLocatorAwareInterface {

    protected $entityClass = "";

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
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
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
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

}