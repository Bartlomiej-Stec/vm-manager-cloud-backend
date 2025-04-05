<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\TaskAnswersList;
use App\Http\Requests\ApplicationRequest;

class GetTaskAnswersController extends Controller
{
    public function __construct(
        private TaskAnswersList $taskAnswersList
    ) {

    }

    public function __invoke(Task $task, ApplicationRequest $request): JsonResponse
    {
        $answers = $this->taskAnswersList->get($task, $request->user());
        return $this->success($answers);
    }
}
