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
     * @param $attributes
     * @return Project
     */
    public function create($attributes)
    {
        $project = new Project();

        foreach ($attributes as $key => $value) {
            if ($key == 'name') {
                $project->setName($value);
            } else if ($key == 'description') {
                $project->setDescription($value);
            } else if ($key == 'private') {
                $project->setPrivate($value);
            } else if ($key == 'blog') {
                $project->setUrl(sha1($value));
            }
        }

        $em = $this->getEntityManager();
        $em->persist($project);

        return $project;
    }

    /**
     * Update user
     *
     * @param $id
     * @param $attributes
     * @return null|Project
     */
    public function update($id, $attributes)
    {
        $project = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key == 'name') {
//                $project->setName($value);
            } else if ($key == 'description') {
                $project->setDescription($value);
            } else if ($key == 'private') {
                $project->setPrivate($value);
            } else if ($key == 'blog') {
                $project->setUrl(sha1($value));
            }
        }

        return $project;
    }

    /**
     * Delete project
     *
     * @param $id
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $object = $em->getPartialReference(self::ENTITY_NAME, array('id' => $id));
        $em->remove($object);
    }

    /**
     * Synchronize with database
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
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