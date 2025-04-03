<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Contracts\RolesAssigner;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RoleChangeRequest;

class AssignUserRoleController extends Controller
{
    public function __construct(
        private RolesAssigner $rolesAssigner
    )
    {

    }

    public function __invoke(RoleChangeRequest $request, User $user): JsonResponse
    {
        $this->rolesAssigner->assignRole($request->role, $user);
        return $this->success(['message' => 'Role assigned successfully']);
    }
}
