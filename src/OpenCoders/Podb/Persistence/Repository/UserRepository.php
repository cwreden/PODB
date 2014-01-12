<?php

namespace OpenCoders\Podb\Persistence\Repository;

use Doctrine\ORM\EntityRepository;
use Luracast\Restler\RestException;

class UserRepository extends EntityRepository
{
    /**
     * @param int $userId User ID
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function getProjects($userId)
    {
        $user = $this->find($userId);

        if ($user == null) {
            throw new RestException(404, "No user found with identifier $userId.");
        }

        return $user->getProjects();
    }

    /**
     * @param $userName
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return
     */
    public function getProjectsByUserName($userName)
    {
        $user = $this->findOneBy(array(
            'username' => $userName
        ));

        if ($user == null) {
            throw new RestException(404, "No user found with identifier $userName.");
        }

        return $user->getProjects();
    }
}