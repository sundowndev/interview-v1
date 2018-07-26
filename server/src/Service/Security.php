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
    public function generateToken($id)
    {
        $token = md5($id . uniqid(rand(), TRUE));

        return $token;
    }

    /**
     * @param $cookie
     * @return bool
     */
    public function isLogged()
    {
        $session = $this->session->getSession($this->getBearerToken());
        $today = date("Y-m-d H:i:s");

        if (is_null($session) || $session['expire_at'] < $today) {
            return false;
        } else {
            return true;
        }
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

    /**
     * Get hearder Authorization
     * */
    function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * Get access token from header
     */
    function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}