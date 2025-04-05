<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Contracts\TaskDeleter;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApplicationRequest;

class DeleteTaskController extends Controller
{
    public function __construct(
        private TaskDeleter $taskDeleter
    ) {

    }

    public function __invoke(Task $task, ApplicationRequest $request): JsonResponse
    {   
        $this->taskDeleter->deleteTask($task, $request->user());
        return $this->success(['message' => 'Task deleted successfully']);
    }
}
