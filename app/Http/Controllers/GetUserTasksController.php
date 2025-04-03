<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Contracts\UserTasksGetter;
use App\Http\Requests\TasksFetchRequest;

class GetUserTasksController extends Controller
{
    public function __construct(
        private UserTasksGetter $userTasksGetter
    ) {

    }

    public function __invoke(User $user, TasksFetchRequest $request): JsonResponse
    {
        $tasks = $this->userTasksGetter->get($user->id, $request->toDto());
        return $this->success($tasks);
    }
}
