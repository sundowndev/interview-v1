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
     * Security constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
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
    public function isLogged($cookie)
    {
        if (is_null($this->session->getSession($cookie))) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $csrf
     * @param $cookie
     * @return bool
     */
    public function isValidCsrf($csrf, $cookie)
    {
        if (is_null($session = $this->session->getSession($cookie))) {
            return false;
        }

        return $session['csrf'] === $csrf;
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