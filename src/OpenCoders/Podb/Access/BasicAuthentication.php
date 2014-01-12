<?php

namespace OpenCoders\Podb\Access;

use Luracast\Restler\iAuthenticate;
use Luracast\Restler\RestException;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Session\SessionManager;

class BasicAuthentication implements iAuthenticate
{

    const REALM = 'Restricted API';

    /**
     * Access verification method.
     *
     * API access will be denied when this method returns false
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return boolean true when api access is allowed false otherwise
     */
    public function __isAllowed()
    {

        if ($this->hasBasicOutInformation()) {

            $username = $_SERVER['PHP_AUTH_USER'];
            $pass = sha1($_SERVER['PHP_AUTH_PW']);

            $em = Doctrine::getEntityManager();
            $repository = $em->getRepository('OpenCoders\Podb\Persistence\Entity\User');

            /** @var User $user */
            $user = $repository->findOneBy(
                array(
                    'username' => $username
                )
            );

            if ($user == null || !$user->checkPassword($pass)) {
                return false;
            }

            $sm = new SessionManager();
            $session = $sm->getSession();
            $session->setAuthenticated(true);

            return true;
        }
        header('WWW-Authenticate: Basic realm="' . self::REALM . '"');
        echo $_SERVER['PHP_AUTH_USER'] . ' - ' . $_SERVER['PHP_AUTH_PW'];
        throw new RestException(401, 'Basic Authentication Required');
    }

    /**
     * @return bool
     */
    private function hasBasicOutInformation()
    {
        return isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']);
    }
}