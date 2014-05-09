<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use OpenCoders\Podb\Persistence\Entity\Project;

class ProjectService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Project';

    /**
     * @var EntityManager
     */
    private $em;

    function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * @return Project[]
     */
    public function getAll()
    {
        $repository = $this->getRepository();
        return $repository->findAll();
    }

    /**
     * @param $id
     * @return null|Project
     */
    public function get($id)
    {
        $repository = $this->getRepository();
        return $repository->find($id);
    }

    /**
     * @param $name
     * @return null|Project
     */
    public function getByName($name)
    {
        $repository = $this->getRepository();
        return $repository->findOneBy(
            array(
                'name' => $name
            )
        );
    }

    /**
     * Returns the ProjectsRepository
     * TODO needed? or extract!
     * @return EntityRepository
     */
    protected function getRepository()
    {
        $repository = $this->getEntityManager()->getRepository(self::ENTITY_NAME);
        return $repository;
    }

    /**
     * Returns the Singleton Instance of the EntityManger
     * TODO needed? or extract!
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->em;
    }
} 