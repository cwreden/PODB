<?php

namespace OpenCoders\PODB\filter;


use Luracast\Restler\iFilter;
use Luracast\Restler\iUseAuthentication;
use OpenCoders\PODB\session\SessionManager;

class RateLimit implements iFilter {

    /**
     * Access verification method.
     *
     * API access will be denied when this method returns false
     *
     * @return boolean true when api access is allowed false otherwise
     */
    public function __isAllowed()
    {
        $rateLimitConfig = include(__DIR__ . '/../../../../config/rateLimit.config.php');
        if ($rateLimitConfig['resetInterval'] == 0) {
            return true;
        }

        $sm = new SessionManager();
        $session = $sm->getSession();

        $limit = $rateLimitConfig['limit'];
        if ($session->isAuthenticated()) {
            $limit = $rateLimitConfig['authenticatedLimit'];
        }
        if ($limit == 0) {
            return true;
        }

        $rate = $session->getAttribute('rateLimit') ? : array('reset_at' => time(), 'used' => 0);

        $actualTime = time();
        if (($rate['reset_at'] + $rateLimitConfig['resetInterval']) - $actualTime <= 0) {
            $rate['reset_at'] = $actualTime;
            $rate['used'] = 0;
        }

        $rate['used']++;
        $session->setAttribute('rateLimit', $rate);

        $remaining = $limit - $rate['used'];
        if ($remaining < 0) {
            $remaining = 0;
        }

        header("X-RateLimit-Limit: " . $limit);
        header("X-RateLimit-Remaining: " . $remaining ? : 0);
        header("X-RateLimit-Reset: " . $rate['reset_at']);

        return ($limit - $rate['used']) >= 0;
    }
}