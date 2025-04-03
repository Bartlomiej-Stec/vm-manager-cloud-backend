<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use App\Contracts\TaskOutputAdder;
use App\Http\Requests\AddTaskOutputRequest;

class AddTaskOutputController extends Controller
{
    public function __construct(
        private TaskOutputAdder $taskOutputAdder,
    ) {
    }

    public function __invoke(Task $task, AddTaskOutputRequest $request): JsonResponse
    {
        $this->taskOutputAdder->add($task, $request->output);
        return $this->success(['message' => 'Task output added successfully']);
    }
}
