<?php

namespace OpenCoders\Podb\config;

/**
 * Class ConfigManager
 * @package OpenCoders\Podb\config
 * @deprecated
 */
class ConfigManager {

    /**
     * Config folder
     */
    private $configPath;

    /**
     * Main Config File
     */
    private $mainConfigFile = 'podb.config.php';

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
    public function getSessionConfig()
    {
        $mainConfig = include($this->configPath . $this->mainConfigFile);

        return $mainConfig['session'];
    }
} 
