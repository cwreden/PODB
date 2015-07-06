<?php

namespace OpenCoders\Podb\Persistence\Repository;

use Doctrine\ORM\EntityRepository;
use OpenCoders\Podb\Persistence\Entity\User;

class UserRepository extends EntityRepository
{

    /**
     * @return User[]
     */
    public function getList()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return null|User
     */
    public function get($id)
    {
        return $this->find($id);
    }

    /**
     * @param $name
     * @return null|User
     */
    public function getByName($name)
    {
        return $this->findOneBy(
            array(
                'username' => $name
            )
        );
    }
}