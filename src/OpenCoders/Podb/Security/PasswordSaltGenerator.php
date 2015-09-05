<?php

namespace OpenCoders\Podb\Security;

use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;

class PasswordSaltGenerator implements PasswordSaltGeneratorInterface
{
    /**
     * @var int
     */
    private $nbBytes;
    /**
     * @var SecureRandom
     */
    private $random;

    /**
     * @param $random
     * @param int $nbBytes
     */
    public function __construct($random = null, $nbBytes = 512)
    {
        $this->random = $random instanceof SecureRandomInterface ? $random : new SecureRandom();
        $this->nbBytes = $nbBytes;
    }


    public function generate()
    {
        return $this->random->nextBytes($this->nbBytes / 8);
    }
}
