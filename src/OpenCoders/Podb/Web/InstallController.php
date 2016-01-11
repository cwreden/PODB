<?php

namespace OpenCoders\Podb\Web;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Security\PasswordSaltGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class InstallController
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var MessageDigestPasswordEncoder
     */
    private $passwordEncoder;
    /**
     * @var PasswordSaltGenerator
     */
    private $passwordSaltGenerator;

    /**
     * InstallController constructor.
     * @param EntityManager $entityManager
     * @param MessageDigestPasswordEncoder $passwordEncoder
     * @param PasswordSaltGenerator $passwordSaltGenerator
     */
    public function __construct(
        EntityManager $entityManager,
        MessageDigestPasswordEncoder $passwordEncoder,
        PasswordSaltGenerator $passwordSaltGenerator
    )
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->passwordSaltGenerator = $passwordSaltGenerator;
    }

    /**
     * @return JsonResponse
     */
    public function installAction()
    {
        $user = $this->initDefaultUser();

        return new JsonResponse(array(
            'id' => $user->getId(),
            'username' => $user->getUsername()
        ));
    }

    /**
     * @return User
     * @throws \OpenCoders\Podb\Exception\EmptyParameterException
     */
    private function initDefaultUser()
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setDisplayName('Admin');
        $user->setActive(true);
        $user->setEmailValidated(true);
        $user->setValidated(true);
        $user->setEmail('admin@localhost');

        $salt = $this->passwordSaltGenerator->generate();
        $user->setSalt($salt);
        $password = $this->passwordEncoder->encodePassword('admin', $salt);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
