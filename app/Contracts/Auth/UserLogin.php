<?php

namespace App\Contracts\Auth;

interface UserLogin
{
    public function login(array $credentials): string;
}
