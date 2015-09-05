<?php

namespace OpenCoders\Podb\Security;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RateLimiter
{
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $authenticatedLimit;
    /**
     * @var int
     */
    private $resetInterval;
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param $limit
     * @param $authenticatedLimit
     * @param $resetInterval
     * @param SessionInterface $session
     */
    public function __construct(
        $limit,
        $authenticatedLimit,
        $resetInterval,
        SessionInterface $session
    ) {
        $this->limit = $limit;
        $this->authenticatedLimit = $authenticatedLimit;
        $this->resetInterval = $resetInterval;
        $this->session = $session;
    }

    /**
     *
     */
    public function increaseUsed()
    {
        $limit = $this->getActiveLimit();
        if ($limit == 0) {
            return;
        }

        $rate = $this->getRateInformation();
        $rate['used']++;

        if ($rate['used'] > $limit) {
            throw new RateLimitException('Max rate limit exceeded!');
        }
        $this->session->set('rateLimit', $rate);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getAuthenticatedLimit()
    {
        return $this->authenticatedLimit;
    }

    public function getRemaining()
    {
        $remaining = $this->getLimit() - $this->getUsed();
        if ($remaining < 0) {
            $remaining = 0;
        }
        return $remaining;
    }

    /**
     * @return int
     */
    public function getResetAt()
    {
        $rate = $this->getRateInformation();
        return $rate['reset_at'];
    }

    /**
     * @return int
     */
    private function getUsed()
    {
        $rate = $this->getRateInformation();
        return $rate['used'];
    }

    /**
     * @return array
     */
    protected function getRateInformation()
    {
        $rate = $this->session->get('rateLimit');
        if (!is_array($rate)) {
            $rate = array(
                'reset_at' => (time() + $this->resetInterval),
                'used' => 0
            );
        }

        $actualTime = time();
        if (isset($rate['reset_at']) && $rate['reset_at'] - $actualTime <= 0) {
            $rate['reset_at'] = ($actualTime + $this->resetInterval);
            $rate['used'] = 0;
        }
        return $rate;
    }

    /**
     * @return int
     */
    private function getActiveLimit()
    {
        $limit = $this->getLimit();
        // TODO use symfony security layer
        if ($this->session->get('authenticated') === true) {
            $limit = $this->getAuthenticatedLimit();
        }
        return $limit;
    }
}
