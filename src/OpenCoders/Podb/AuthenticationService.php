<?php

namespace OpenCoders\Podb;

use OpenCoders\Podb\Exception\AuthenticationRequiredException;
use OpenCoders\Podb\Exception\InactiveUserAccountException;
use OpenCoders\Podb\Exception\InvalidUsernamePasswordCombinationException;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Persistence\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class AuthenticationService
 * @package OpenCoders\Podb\Service
 * @deprecated
 * TODO refactor by silex security layer
 */
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

    public function __construct($session, UserRepository $userRepository)
    {
        $this->session = $session;
        $this->userRepository = $userRepository;
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
        } elseif ($user->getActive() === 0 || $user->getEmailValidated() === false) {
            throw new InactiveUserAccountException();
        }
        $this->session->set('authenticated', true);
        $this->session->set('userId', $user->getId());

        return $user;
    }

    /**
     * @deprecated
     */
    public function logout()
    {
        $this->session->set('authenticated', false);
        $this->session->remove('userId');
    }

    /**
     * @return null|User
     */
    public function getCurrentUser()
    {
        return $this->userRepository->get($this->session->get('userId'));
    }

    /**
     *
     */
    public function lockSession()
    {
        $this->session->set('locked', true);
    }

    /**
     * @param $password
     * @throws \OpenCoders\Podb\Exception\InvalidUsernamePasswordCombinationException
     */
    public function unlockSession($password)
    {
        $currentUser = $this->getCurrentUser();

        if ($currentUser == null || !$currentUser->checkPassword($password)) {
            throw new InvalidUsernamePasswordCombinationException();
        }
        $this->session->remove('locked');
    }
}
