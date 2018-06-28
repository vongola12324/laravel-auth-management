<?php

namespace Vongola\Auth\Services;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Vongola\Auth\AuthManager;

class AuthService
{
    public function getLoginEvent()
    {
        return \Illuminate\Auth\Events\Login::class;
    }

    public function getLogoutEvent()
    {
        return \Illuminate\Auth\Events\Logout::class;
    }

    public function user(Authenticatable $user)
    {
        return new AuthManager($user);
    }

}