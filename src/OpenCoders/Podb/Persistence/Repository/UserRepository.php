<?php

namespace OpenCoders\Podb\Persistence\Repository;

use Doctrine\ORM\EntityRepository;
use Luracast\Restler\RestException;
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

        if (!$user instanceof User) {
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

        if (!$user instanceof User) {
            throw new RestException(404, "No user found with identifier $userName.");
        }

        return $user->getProjects();
    }

    /**
     * @param $attributes
     * @return User
     * @deprecated
     */
    public function create($attributes)
    {
        $user = new User();

        foreach ($attributes as $key => $value) {
            if ($key == 'username') {
                $user->setUsername($value);
            } else if ($key == 'displayName') {
                $user->setDisplayName($value);
            } else if ($key == 'email') {
                $user->setEmail($value);
            } else if ($key == 'password') {
                $user->setPassword(sha1($value));
            } else if ($key == 'active') {
                $user->setActive($value);
            } else if ($key == 'gravatarEMail') {
                $user->setGravatarEMail($value);
            } else if ($key == 'company') {
                $user->setCompany($value);
            } else if ($key == 'publicEMail') {
                $user->setPublicEMail($value);
            } else if ($key == 'supportedLanguages') {
                $user->setSupportedLanguages($value);
            } else if ($key == 'emailValidated') {
                $user->setEmailValidated($value);
            }
        }

        $this->getEntityManager()->persist($user);

        return $user;
    }

    /**
     * Update user
     *
     * @param $id
     * @param $attributes
     * @return null|User
     * @deprecated
     */
    public function update($id, $attributes)
    {
        $user = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key == 'username') {
//                $user->setUsername($value);
            } else if ($key == 'displayName') {
                $user->setDisplayName($value);
            } else if ($key == 'email') {
                $user->setEmail($value);
            } else if ($key == 'password') {
                $user->setPassword(sha1($value));
            } else if ($key == 'active') {
                $user->setActive($value);
            } else if ($key == 'gravatarEMail') {
                $user->setGravatarEMail($value);
            } else if ($key == 'company') {
                $user->setCompany($value);
            } else if ($key == 'publicEMail') {
                $user->setPublicEMail($value);
            } else if ($key == 'supportedLanguages') {
                $user->setSupportedLanguages($value);
            } else if ($key == 'emailValidated') {
                $user->setEmailValidated($value);
            }
        }

        return $user;
    }
}