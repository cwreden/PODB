<?php

namespace OpenCoders\PODB\session;


class SessionManager {

    /**
     * @var bool
     */
    private static $sessionStarted = false;

    /**
     * @return Session
     */
    public function getSession()
    {
        if (!$this::$sessionStarted) {
            session_start();
            $this::$sessionStarted = true;
        }

        return new Session();
    }
} 