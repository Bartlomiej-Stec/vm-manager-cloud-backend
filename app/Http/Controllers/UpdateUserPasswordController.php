<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Contracts\PasswordUpdater;
use App\Http\Requests\UpdateUserPasswordRequest;

class UpdateUserPasswordController extends Controller
{
    public function __construct(
        private PasswordUpdater $passwordUpdater
    ) {

    }

    public function __invoke(UpdateUserPasswordRequest $request): JsonResponse
    {
        $this->passwordUpdater->update($request->password, $request->user());
        return $this->success(['message' => 'Password updated successfully']);
    }
}
