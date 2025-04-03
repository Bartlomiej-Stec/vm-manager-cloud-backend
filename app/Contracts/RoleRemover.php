<?php

namespace App\Contracts;

use App\Models\User;
use Spatie\Permission\Models\Role;

interface RoleRemover
{
    public function remove(string $roleName, User $user): void;
}
