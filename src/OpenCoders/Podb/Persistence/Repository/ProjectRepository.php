<?php

namespace OpenCoders\Podb\Persistence\Repository;

use Doctrine\ORM\EntityRepository;
use OpenCoders\Podb\Persistence\Entity\Project;

class ProjectRepository extends EntityRepository
{

    /**
     * @return Project[]
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return null|Project
     */
    public function get($id)
    {
        return $this->find($id);
    }

    /**
     * @param $name
     * @return null|Project
     */
    public function getByName($name)
    {
        return $this->findOneBy(
            array(
                'name' => $name
            )
        );
    }
}