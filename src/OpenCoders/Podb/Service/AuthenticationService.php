<?php

namespace OpenCoders\Podb\Service;


use OpenCoders\Podb\Exception\AuthenticationRequiredException;
use OpenCoders\Podb\Exception\InactiveUserAccountException;
use OpenCoders\Podb\Exception\InvalidUsernamePasswordCombinationException;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Persistence\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthenticationService
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var UserRepository
     */
    private $userRepository;

    function __construct($session, UserRepository $userRepository)
    {
        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \OpenCoders\Podb\Exception\AuthenticationRequiredException
     */
    public function ensureSession()
    {
        if (!$this->isAuthenticated()) {
            throw new AuthenticationRequiredException();
        }
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->session->has('authenticated') && $this->session->get('authenticated');
    }

    /**
     * @param $username
     * @param $password
     *
     * @throws \OpenCoders\Podb\Exception\InactiveUserAccountException
     * @throws \OpenCoders\Podb\Exception\InvalidUsernamePasswordCombinationException
     * @return User
     */
    public function authenticateUser($username, $password)
    {
        /** @var User $user */
        $user = $this->userRepository->getByName($username);

        if ($user == null || !$user->checkPassword($password)) {
            throw new InvalidUsernamePasswordCombinationException();
        } else if ($user->getActive() === 0 || $user->getEmailValidated() === false) {
            throw new InactiveUserAccountException();
        }
        $this->session->set('authenticated', true);
        $this->session->set('userId', $user->getId());

        return $user;
    }

    /**
     *
     */
    public function logout()
    {
        $this->ensureSession();
        $this->session->set('authenticated', false);
        $this->session->remove('userId');
    }

    /**
     * @return null|User
     */
    public function getCurrentUser()
    {
        $this->ensureSession();
        return $this->userRepository->get($this->session->get('userId'));
    }

    /**
     *
     */
    public function lockSession()
    {
        $this->ensureSession();
        $this->session->set('locked', true);
    }

    /**
     * @param $password
     * @throws \OpenCoders\Podb\Exception\InvalidUsernamePasswordCombinationException
     */
    public function unlockSession($password)
    {
        $this->ensureSession();
        $currentUser = $this->getCurrentUser();

        if ($currentUser == null || !$currentUser->checkPassword($password)) {
            throw new InvalidUsernamePasswordCombinationException();
        }
        $this->session->remove('locked');
    }
} 