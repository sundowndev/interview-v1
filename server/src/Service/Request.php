<?php

namespace App\Service;

/**
 * Class JsonResponse
 * @package App\Service
 */
class Request
{
    private $content;

    public function getContent()
    {
        $this->content = trim(file_get_contents("php://input")) ?? [];

        return $this;
    }

    public function asPlainText(){
        return (string) $this->content;
    }

    public function jsonToArray(){
        return json_decode($this->content, true);
    }
}