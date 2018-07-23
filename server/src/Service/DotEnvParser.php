<?php

namespace App\Service;

use Codervio\Envmanager\Envparser;

/**
 * Class DotEnvParser
 * @package App\Service
 */
class DotEnvParser
{
    private $file;
    private $parser;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../.env';

        $this->parser = new Envparser($this->file);
        $this->parser->load();
    }

    public function run()
    {
        $this->parser->run();
    }
}
