<?php

namespace App\Contracts\Auth;

use App\DTOs\UserRegisterDto;
use App\ValueObjects\CreatedUserObj;

interface UserRegister
{
    public function register(UserRegisterDto $dto): CreatedUserObj;
}
