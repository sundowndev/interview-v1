<?php

namespace App\Service;

/**
 * Class JsonResponse
 * @package App\Service
 */
class Request
{
    public function getContentAsArray()
    {
        return $content = json_decode(trim(file_get_contents("php://input")), true) ?? [];
    }
}