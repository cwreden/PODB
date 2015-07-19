<?php

namespace OpenCoders\Podb;


class Manager
{
    /**
     * @var string
     */
    private $applicationName;

    /**
     * @param $applicationName
     */
    function __construct(
        $applicationName
    )
    {
        $this->applicationName = $applicationName;
    }

    /**
     * @return string
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }
}
