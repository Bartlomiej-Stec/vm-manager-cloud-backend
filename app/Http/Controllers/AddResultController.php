<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Contracts\ResultAdder;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AddResultRequest;

class AddResultController extends Controller
{
    public function __construct(
        private ResultAdder $resultAdder
    ) {

    }

    public function __invoke(AddResultRequest $request, Task $task): JsonResponse
    {
        $this->resultAdder->add($request->toDto());
        return $this->success(['message' => 'Answer added successfully'], 201);
    }
}
