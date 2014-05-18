<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Persistence\Entity\Project;

class ProjectService extends BaseEntityService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Project';

    function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, self::ENTITY_NAME);
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
            if ($key === 'name') {
                $project->setName($value);
            } else if ($key === 'description') {
                $project->setDescription($value);
            } else if ($key === 'private') {
                $project->setPrivate($value);
            } else if ($key === 'blog') {
                $project->setUrl(sha1($value));
            } elseif ($key === 'owner') {
                $project->setOwner($value);
            } elseif ($key === 'contributors') {
                $project->setContributors($value);
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
} 