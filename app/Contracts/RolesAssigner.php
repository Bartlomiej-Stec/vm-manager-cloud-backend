<?php

namespace App\Contracts;

use App\Models\User;

interface RolesAssigner
{
    public function assignRole(string $roleName, User $user): void;
}
