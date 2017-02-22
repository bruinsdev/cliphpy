<?php

namespace Cliphpy\Prototype;

use Cliphpy\Exception;

class Configuration
{
    /**
     * @var string
     */
    public $logDir;

    /**
     * @var string
     */
    public $pidDir;

    public function __construct()
    {
        $this->logDir = __DIR__.'/../log';
        $this->pidDir = __DIR__.'/../pid';
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        if (is_null($this->environment)) {
            throw new Exception('Property environment is not set in settings', 1);
        }

        return $this->environment;
    }
}
