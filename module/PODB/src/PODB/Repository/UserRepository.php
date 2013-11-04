<?php

namespace PODB\Repository;

use PODB\Entity\User;

class UserRepository extends Repository
{
    protected $entityClass = 'PODB\Entity\User';

    /**
     * @return User[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param User $entity
     * @return integer
     */
    public function create(User $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity->getId();
    }

    /**
     * @param User $entity
     */
    public function update(User $entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $id
     * @return User
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

}