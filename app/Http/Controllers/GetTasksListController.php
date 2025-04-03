<?php

namespace App\Http\Controllers;

use App\Contracts\TaskListGetter;
use App\Http\Requests\TasksFetchRequest;
use Illuminate\Http\JsonResponse;

class GetTasksListController extends Controller
{
    public function __construct(
        private TaskListGetter $taskListGetter
    ) {

    }

    public function __invoke(TasksFetchRequest $request): JsonResponse
    {
        $data = $this->taskListGetter->getTasksList($request->toDto());
        return $this->success($data);
    }
}
