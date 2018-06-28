<?php

namespace Vongola\Auth\Facades;

use Illuminate\Support\Facades\Facade;

class AuthManagementFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vongola\Auth\Services\AuthService::class;
    }
}