<?php

namespace App\Services;

use App\Models\User;
use App\Contracts\RolesAssigner;

class RolesAssignerService implements RolesAssigner 
{
	public function assignRole(string $roleName, User $user): void 
    {
        $user->assignRole($roleName);
    }

}
