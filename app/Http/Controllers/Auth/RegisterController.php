<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Contracts\Auth\UserRegister;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function __construct(
        private UserRegister $userRegister
    ){

    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $createdUser = $this->userRegister->register($request->toDto());
        return $this->success($createdUser->toArray(), 201);
    }
}
