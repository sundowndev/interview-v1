<?php

namespace App\Service;

use josegonzalez\Dotenv\Loader;

/**
 * Class DotEnvParser
 * @package App\Service
 */
class DotEnvParser
{
    private $file;
    private $loader;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../.env';
        $this->loader = new Loader($this->file);
    }

    /**
     * Parse the .env file
     * @return bool|Loader
     */
    public function parse()
    {
        return $this->loader->parse();
    }

    /**
     * Send the parsed .env file to the $_ENV variable
     * @return bool|Loader
     */
    public function toEnv()
    {
        return $this->loader->toEnv();
    }

    /**
     * @return array|null
     */
    public function toArray()
    {
        return $this->loader->toArray();
    }
}