<?php

namespace OpenCoders\PODB\API;


use OpenCoders\PODB\helper\Doctrine;
use OpenCoders\PODB\Repository\ProjectRepository;

abstract class AbstractBaseApi {

    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\PODB\Entity\Project';

    /**
     * @var string Api Version
     */
    protected $apiVersion = 'v1';

    /**
     * @var
     */
    private $em;

    function __construct()
    {
        $this->em = Doctrine::getEntityManager();
    }

    /**
     * Returns the ProjectsRepository
     * @return ProjectRepository
     */
    protected function getRepository()
    {
        $repository = $this->getEntityManager()->getRepository($this->entityName);
        return $repository;
    }

    /**
     * Returns the Singleton Instance of the EntityManger
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Returns the used API Version
     * @return string
     */
    protected function getApiVersion()
    {
        return $this->apiVersion;
    }
}