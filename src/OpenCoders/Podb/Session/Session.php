<?php

namespace OpenCoders\Podb\Session;

use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Persistence\Entity\User;

/**
 * Class Session
 * @deprecated
 * @package OpenCoders\Podb\Session
 */
class Session
{

    function __construct()
    {
        if (!isset($_SESSION['last_activity'])) {
            $_SESSION['last_activity'] = time();
        }
        if (!isset($_SESSION['attributes'])) {
            $_SESSION['attributes'] = array();
        }
    }

    /**
     * Sets given Attribute to given value
     *
     * @param string $key Identifier
     * @param mixed $attribute Value
     *
     * @return void
     */
    public function setAttribute($key, $attribute)
    {
        $_SESSION['attributes'][$key] = $attribute;
    }

    /**
     * Returns value in Session for given identifier
     *
     * @param $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (isset($_SESSION['attributes'][$key])) {
            return $_SESSION['attributes'][$key];
        }
        return null;
    }

    /**
     * Deletes value of Session from given identifier
     *
     * @param $key
     *
     * @return void
     */
    public function removeAttribute($key)
    {
        if (isset($_SESSION['attributes'][$key])) {
            unset($_SESSION['attributes'][$key]);
        }
    }

    /**
     * Returns true if user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] ? true : false;
    }

    /**
     * Sets if user is authenticated or not
     *
     * @param bool $isAuthenticated
     *
     * @return void
     */
    public function setAuthenticated($isAuthenticated = false)
    {
        $_SESSION['authenticated'] = $isAuthenticated;
    }

    /**
     * Returns the timestamp of last activity
     *
     * @return string
     */
    public function getLastActivityTime()
    {
        return $_SESSION['last_activity'];
    }

    /**
     * Updates actual timestamp in last_activity in Session
     *
     * @return void
     */
    public function updateLastActivityTime()
    {
        $_SESSION['last_activity'] = time();
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        if (!isset($_SESSION['userId'])) {
            return null;
        }
        $em = Doctrine::getEntityManager();

        return $em->getRepository('OpenCoders\Podb\Persistence\Entity\User')->find($_SESSION['userId']);
    }

    /**
     * @param $id int
     */
    public function setUserId($id)
    {
        $_SESSION['userId'] = $id;
    }
} 
