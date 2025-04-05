<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Contracts\TaskGetter;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApplicationRequest;

class GetTaskController extends Controller
{
    public function __construct(
        private TaskGetter $taskGetter
    )
    {

    }

    public function __invoke(Task $task, ApplicationRequest $request): JsonResponse
    {
        $task = $this->taskGetter->getTask($task->id, $request->user()->id);
        return $this->success($task->toArray());
    }
}
