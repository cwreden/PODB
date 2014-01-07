<?php

namespace OpenCoders\PODB\Repository;

use OpenCoders\PODB\Entity\Project;

class ProjectRepository extends Repository
{
    protected $entityClass = 'PODB\Entity\Project';

    /**
     * @return Project[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param Project $entity
     * @return integer
     */
    public function create(Project $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity->getId();
    }

    /**
     * @param Project $entity
     */
    public function update(Project $entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $id
     * @return Project
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }
}