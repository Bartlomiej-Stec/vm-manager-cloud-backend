<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Contracts\Auth\UserLogout;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __construct(
        private UserLogout $userLogout
    ) {

    }

    public function __invoke(): JsonResponse
    {
        $this->userLogout->logout();
        return $this->success(['message' => 'User logged out successfully']);
    }
}
