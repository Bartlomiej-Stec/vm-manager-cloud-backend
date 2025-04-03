<?php

namespace App\Services\Auth;

use App\Models\User;
use App\DTOs\UserRegisterDto;
use App\Contracts\Auth\UserRegister;
use App\ValueObjects\CreatedUserObj;

class UserRegisterService implements UserRegister 
{
	public function register(UserRegisterDto $dto): CreatedUserObj 
    {
        $user = User::create($dto->toArray());
        return CreatedUserObj::fromModel($user);
    }

}
