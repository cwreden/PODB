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
     *
     */
    public function __construct ()
    {
        $this->configPath = __DIR__ . '/../../../../config/';
    }

}