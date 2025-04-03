<?php

namespace App\Services\Auth;

use App\Contracts\Auth\UserLogin;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UserInvalidCredentialsException;

class UserLoginService implements UserLogin
{
    public function login(array $credentials): string
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new UserInvalidCredentialsException('Invalid credentials');
        }
        $user = Auth::user();
        return JWTAuth::claims(['role' => $user->role])->fromUser($user);
    }

}
