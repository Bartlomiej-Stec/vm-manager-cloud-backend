<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Auth\UserLogin;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function __construct(
        private UserLogin $userLogin
    )
    {

    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $token = $this->userLogin->login($request->only(['email', 'password']));
        return $this->success(['token' => $token]);
    }
}
