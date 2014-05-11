<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Persistence\Entity\User;

class UserService extends BaseEntityService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\User';

    function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, self::ENTITY_NAME);
    }

    /**
     * @return User[]
     */
    public function getList()
    {
        $repository = $this->getRepository();
        return $repository->findAll();
    }

    /**
     * @param $id
     * @return null|User
     */
    public function get($id)
    {
        $repository = $this->getRepository();

        return $repository->find($id);
    }

    /**
     * @param $name
     * @return null|User
     */
    public function getByName($name)
    {
        $repository = $this->getRepository();

        return $repository->findOneBy(
            array(
                'username' => $name
            )
        );
    }

    /**
     * @param $attributes
     * @return User
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

        $em = $this->getEntityManager();
        $em->persist($user);

        return $user;
    }

    /**
     * Update user
     *
     * @param $id
     * @param $attributes
     * @return null|User
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