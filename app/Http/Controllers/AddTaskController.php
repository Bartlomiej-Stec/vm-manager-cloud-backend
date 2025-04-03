<?php

namespace App\Http\Controllers;

use App\Contracts\TaskAdder;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AddTaskRequest;

class AddTaskController extends Controller
{
    public function __construct(
        private TaskAdder $addTask
    ) {
    }

    public function __invoke(AddTaskRequest $request): JsonResponse
    {
        $this->addTask->add($request->toDto());
        return $this->success(['message' => 'Task added successfully'], 201);
    }
}
