<?php

namespace App\Http\Controllers;

use App\Contracts\UserGetter;
use Illuminate\Http\JsonResponse;

class GetUserController extends Controller
{
    public function __construct(
        private UserGetter $userGetter
    ) {
    }

    public function __invoke(): JsonResponse
    {
        return $this->success($this->userGetter->get()->toArray());
    }
}
