<?php

namespace App\Service;

/**
 * Class JsonResponse
 * @package App\Service
 */
class JsonResponse
{
    public function create(int $code, string $message = null, array $data = []): ?string
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

        //header('Access-Control-Allow-Origin: ' . getenv('ALLOW_ORIGIN'));
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Max-Age: 1');
        header('Accept: application/json');
        header('Content-Type: application/json');
        http_response_code($code);

        print json_encode($response);
        exit();
    }
}