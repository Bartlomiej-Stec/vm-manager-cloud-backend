<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\UserTaskAnswerGetter;
use App\Http\Requests\ApplicationRequest;

class GetUserTaskAnswerController extends Controller
{
    public function __construct(
        private UserTaskAnswerGetter $userTaskAnswerGetter
    ) {

    }

    public function __invoke(Task $task, ApplicationRequest $request): JsonResponse
    {
        $answer = $this->userTaskAnswerGetter->get($request->user()->id, $task->id);
        return $this->success($answer->toArray());
    }
}
