<?php

namespace OpenCoders\Podb\Api\v1;


use Luracast\Restler\RestException;
use OpenCoders\Podb\Api\AbstractBaseApi;
use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Session\SessionManager;

/**
 * Class Authentication
 * @package OpenCoders\Podb\Api\v1
 */
class Authentication extends AbstractBaseApi {

    /**
     * @url POST /login
     */
    public function login($request_data = NULL)
    {

        $sm = new SessionManager();
        $session = $sm->getSession();

        if ($session->isAuthenticated()) {
            throw new \Exception('Already logged in.');
        }

        if (!isset($request_data['username'])) {
            throw new RestException(400, 'Missing parameter username');
        } else if (!isset($request_data['password'])) {
            throw new RestException(400, 'Missing parameter password');
        }

        $username = $request_data['username'];
        $password = $request_data['password'];

        $em = Doctrine::getEntityManager();
        $repository = $em->getRepository('OpenCoders\Podb\Persistence\Entity\User');

        /** @var User $user */
        $user = $repository->findOneBy(
            array(
                'username' => $username
            )
        );

        if ($user == null || !$user->checkPassword($password)) {
            throw new RestException(401, 'Authentication invalid' . sha1($password));
        }
        $session->setAuthenticated(true);
        $session->setUserId($user->getId());

        return array(
            'success' => true,
            'displayName' => $session->getUser()->getDisplayName()
        );
    }

    /**
     * @url POST /logout
     *
     * @protected
     *
     * @return bool
     */
    public function logout()
    {
        $sm = new SessionManager();
        $session = $sm->getSession();
        $session->setAuthenticated(false);
        return array(
            'success' => true
        );
    }

    /**
     * @url GET /isLoggedIn
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        $sm = new SessionManager();
        $session = $sm->getSession();

        if (!$session->isAuthenticated()) {
            return array(
                'isLoggedIn' => false
            );
        }

        $currentUser = $session->getUser();

        return array(
            'isLoggedIn' => $session->isAuthenticated(),
            'username' => $currentUser->getUsername(),
            'displayName' => $currentUser->getDisplayName()
        );
    }

    /**
     * @url POST /lock
     *
     */
    public function lock()
    {
        $sm = new SessionManager();
        $session = $sm->getSession();

        if (!$session->isAuthenticated()) {
            throw new RestException(401, 'Authentication required');
        }

        $session->setAttribute('locked', true);

        return array(
            'success' => true
        );
    }

    /**
     * @url POST /unlock
     */
    public function unlock($request_data = NULL)
    {
        $sm = new SessionManager();
        $session = $sm->getSession();

        if (!$session->isAuthenticated()) {
            throw new RestException(401, 'Open session required');
        } else if (!isset($request_data['password'])) {
            throw new RestException(400, 'Missing parameter password');
        }

        $user = $session->getUser();
        if (!$user->checkPassword($request_data['password'])) {
            throw new RestException(401, 'Authentication invalid');
        }

        return array(
            'success' => true
        );
    }
} 