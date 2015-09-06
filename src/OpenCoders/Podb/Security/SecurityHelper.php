<?php

namespace OpenCoders\Podb\Security;


use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class SecurityHelper extends Helper
{
    /**
     * @var MessageDigestPasswordEncoder
     */
    private $passwordEncoder;
    /**
     * @var PasswordSaltGenerator
     */
    private $passwordSaltGenerator;

    /**
     * @param MessageDigestPasswordEncoder $passwordEncoder
     * @param PasswordSaltGenerator $passwordSaltGenerator
     */
    function __construct(
        MessageDigestPasswordEncoder $passwordEncoder,
        PasswordSaltGenerator $passwordSaltGenerator
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->passwordSaltGenerator = $passwordSaltGenerator;
    }

    /**
     * @return MessageDigestPasswordEncoder
     */
    public function getPasswordEncoder()
    {
        return $this->passwordEncoder;
    }

    /**
     * @return PasswordSaltGenerator
     */
    public function getPasswordSaltGenerator()
    {
        return $this->passwordSaltGenerator;
    }

    public function getName()
    {
        return 'security';
    }
}
