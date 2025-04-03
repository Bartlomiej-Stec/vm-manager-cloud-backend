<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Contracts\TaskUpdater;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AddTaskRequest;

class UpdateTaskController extends Controller
{
    public function __construct(
        private TaskUpdater $taskUpdater
    ) {
    }

    public function __invoke(AddTaskRequest $request, Task $task): JsonResponse
    {
        $this->taskUpdater->updateTask($task, $request->toDto());
        return $this->success(['message' => 'Task updated successfully']);
    }
}
