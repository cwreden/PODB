<?php

namespace OpenCoders\Podb\Persistence\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class EntityRepositoryAbstract
 * TODO after refactorying removed this class and extend all entities directly from EntityRepository
 * @package OpenCoders\Podb\Persistence\Repository
 * @deprecated
 */
class EntityRepositoryAbstract extends EntityRepository
{
    /**
     * Synchronize with database
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    /**
     * Delete
     *
     * @param $id
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $object = $em->getPartialReference($this->getEntityName(), array('id' => $id));
        $em->remove($object);
    }
}
