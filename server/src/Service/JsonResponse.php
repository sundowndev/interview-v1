<?php

namespace App\Service;

class JsonResponse
{
    public function create(int $code, string $message = null, array $data = [])
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

        header('Content-Type: application/json');
        http_response_code($code);

        return json_encode($response);
    }
}