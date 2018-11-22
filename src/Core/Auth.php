<?php

namespace App\Core;

use Aura\Session\Segment;

class Auth
{
    const ADMIN_USER = 'admin';
    const ADMIN_PASSWORD = '123';

    /**
     * @var Segment
     */
    protected $userSession;

    /**
     * Auth constructor.
     * @param Segment $segment
     */
    public function __construct(Segment $segment)
    {
        $this->userSession = $segment;
    }

    /**
     * @param array $credentials
     * @return bool
     * @throws \Exception
     */
    public function authenticate(array $credentials)
    {
        if (!array_key_exists('username', $credentials) || !array_key_exists('password', $credentials)) {
            throw new \Exception("Missing credentials ('username' and 'password' must be set)");
        }

        return $credentials['username'] === self::ADMIN_USER && $credentials['password'] === self::ADMIN_PASSWORD;
    }

    /**
     * @param array $credentials
     * @return bool
     * @throws \Exception
     */
    public function login(array $credentials): bool
    {
        $authenticated = $this->authenticate($credentials);

        if (!$authenticated) {
            return false;
        }

        $this->userSession->set('authenticated', true);

        return true;
    }

    public function logout()
    {
        $this->userSession->set('authenticated', false);
    }

    /**
     * @return bool | null
     */
    public function isAuthenticated()
    {
        return $this->userSession->get('authenticated');
    }
}