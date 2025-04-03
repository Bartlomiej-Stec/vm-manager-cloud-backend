<?php

namespace App\Services\Auth;

use App\Contracts\Auth\UserLogout;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserLogoutService implements UserLogout 
{
	public function logout(): void 
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

}
