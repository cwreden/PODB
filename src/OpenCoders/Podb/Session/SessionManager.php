<?php

namespace OpenCoders\Podb\Session;


use OpenCoders\Podb\config\ConfigManager;

/**
 * Class SessionManager
 * @deprecated
 * @package OpenCoders\Podb\Session
 */
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
            ini_set('session.gc_maxlifetime', $this->getSessionConfig()['lifetime']);
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
        $session = new Session();

        return (time() - $session->getLastActivityTime()) <= $this->getSessionConfig()['timeout'];
    }

    private function getSessionConfig()
    {
        $cm = new ConfigManager();
        return $cm->getSessionConfig();
    }
} 
