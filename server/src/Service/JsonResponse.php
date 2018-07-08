<?php

namespace App\Service;

class JsonResponse
{
    public function create(array $data, $code)
    {
        $response = json_encode($data);

        header('Content-Type: application/json');
        http_response_code($code);

        return $response;
    }
}