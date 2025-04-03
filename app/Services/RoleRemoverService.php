<?php

namespace App\Services;

use App\Models\User;
use App\Contracts\RoleRemover;
class RoleRemoverService implements RoleRemover
{
    public function remove(string $roleName, User $user): void
    {
        $user->removeRole($roleName);
    }

}
