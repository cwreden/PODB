<?php

namespace OpenCoders\Podb\Persistence\Repository;

use Doctrine\ORM\EntityRepository;
use OpenCoders\Podb\Persistence\Entity\Message;
use OpenCoders\Podb\Persistence\Entity\Project;

/**
 * Class MessageRepository
 * @package OpenCoders\Podb\Persistence\Repository
 */
class MessageRepository extends EntityRepository
{
    /**
     * @param Project $project
     * @param null $domainId
     * @return Message[]
     */
    public function getListByProject(Project $project, $domainId = null)
    {
        $criteria = array(
            'project' => $project->getId()
        );
        if ($domainId !== null) {
            $criteria['domain'] = $domainId;
        }
        return $this->findBy($criteria);
    }

    /**
     * @param $id
     * @return null|Message
     */
    public function get($id)
    {
        return $this->find($id);
    }
}
