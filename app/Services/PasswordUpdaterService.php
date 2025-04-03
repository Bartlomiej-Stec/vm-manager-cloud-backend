<?php

namespace App\Services;

use App\Models\User;
use App\Contracts\PasswordUpdater;
use Illuminate\Support\Facades\Hash;

class PasswordUpdaterService implements PasswordUpdater 
{
	public function update(string $password, User $user): void 
    {
        $user->update(['password' => Hash::make($password)]);
    }

}
