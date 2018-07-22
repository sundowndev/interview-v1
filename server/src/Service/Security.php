<?php

namespace App\Service;

/**
 * Class Security
 * @package App\Service
 */
class Security
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var JsonResponse
     */
    private $jsonResponse;

    /**
     * @var $secret_key
     */
    private $secret_key;

    /**
     * Security constructor.
     */
    public function __construct(Session $session, JsonResponse $jsonResponse)
    {
        $this->session = $session;
        $this->jsonResponse = $jsonResponse;
        $this->secret_key = getenv('APP_SECRET');
    }

    /**
     * @return string
     */
    public function generateToken()
    {
        $token = md5(uniqid(rand(), TRUE));

        return $token;
    }

    /**
     * @param $cookie
     * @return bool
     */
    public function isLogged()
    {
        return false;
    }

    /**
     * @return string
     */
    public function NotAllowedRequest()
    {
        $code = 403;
        $message = 'You are not allowed to perform this request.';
        $data = [];

        return $this->jsonResponse->create($code, $message, $data);
    }

    /**
     * @param $password
     * @return bool|string
     */
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, [
            'cost' => 12
        ]);
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    public function passwordVerify($password, $hash)
    {
        return \password_verify($password, $hash);
    }
}