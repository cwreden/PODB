<?php

namespace OpenCoders\Podb\Configuration;

/**
 * Class ConfigurationService
 * @package OpenCoders\Podb\Configuration
 * @deprecated
 */
class ConfigurationService
{
    /**
     * Config folder
     */
    private $configPath;

    /**
     * Main Config File
     */
    private $mainConfigFile = 'podb.config.php';

    /**
     * Rate limit config File
     */
    private $rateLimitConfigFile = 'rateLimit.config.php';

    /**
     *
     */
    public function __construct ()
    {
        $this->configPath = __DIR__ . '/../../../../config/';
    }

    /**
     * @return array
     */
    public function getRateLimit ()
    {
        return include($this->configPath . $this->rateLimitConfigFile);
    }

    /**
     * @return array
     */
    public function getSessionConfig()
    {
        $mainConfig = include($this->configPath . $this->mainConfigFile);

        return $mainConfig['session'];
    }
} 