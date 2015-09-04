<?php

namespace OpenCoders\Podb\Persistence\Repository;

use Doctrine\ORM\EntityRepository;
use OpenCoders\Podb\Persistence\Entity\Domain;
use OpenCoders\Podb\Persistence\Entity\Project;

/**
 * Class DomainRepository
 * @package OpenCoders\Podb\Persistence\Repository
 */
class DomainRepository extends EntityRepository
{

    /**
     * @param $id
     * @return null|Domain
     */
    public function get($id)
    {
        return $this->find($id);
    }

    /**
     * @param Project $project
     * @param $domainName
     * @return null|Domain
     */
    public function getByName(Project $project, $domainName)
    {
        return $this->findOneBy(array(
            'project' => $project->getId(),
            'name' => $domainName
        ));
    }

    /**
     * @param Project $project
     * @return Domain[]
     */
    public function getAllForProject(Project $project)
    {
        return $this->findBy(array(
            'project' => $project->getId()
        ));
    }
}
