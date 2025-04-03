<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Contracts\RoleRemover;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class RemoveUserRoleController extends Controller
{
    public function __construct(
        private RoleRemover $rolesAssigner
    )
    {

    }

    public function __invoke(User $user, string $role): JsonResponse
    {
        $this->rolesAssigner->remove($role, $user);
        return $this->success(['message' => 'Role removed successfully']);
    }   
}
