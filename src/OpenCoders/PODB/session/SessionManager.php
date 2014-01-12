<?php

namespace OpenCoders\PODB\session;


use OpenCoders\PODB\config\ConfigManager;

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

    /**
     * @return bool
     */
    public function isSessionActive()
    {
        $cm = new ConfigManager();
        $sessionConfig = $cm->getSessionConfig();
        $session = new Session();

        return (time() - $session->getLastActivityTime()) <= $sessionConfig['timeout'];
    }
} 
