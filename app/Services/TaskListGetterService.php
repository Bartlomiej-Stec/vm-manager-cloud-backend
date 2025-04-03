<?php

namespace App\Services;

use App\Models\Task;
use App\DTOs\TasksFilterDto;
use App\Contracts\TagPlucker;
use App\Contracts\TasksFilter;
use App\Contracts\TaskListGetter;

class TaskListGetterService implements TaskListGetter
{
    private const ITEMS_PER_PAGE = 20;

    public function __construct(
        private TagPlucker $tagPlucker,
        private TasksFilter $tasksFilter
    ) {

    }

    public function getTasksList(TasksFilterDto $dto): array
    {
        $query = Task::select('title', 'id', 'level', 'content', 'input', 'created_at', 'updated_at', 'created_by')
            ->with(['user:id,name,surname', 'tags:task_id,name']);
        $this->tasksFilter->filter($query, $dto);
        $tasks = $query->orderBy('created_at', 'desc')
            ->paginate(self::ITEMS_PER_PAGE)
            ->through(function ($task) {
                $task->created_by = $task->user;
                unset($task->user);
                return $task;
            });
        return $this->tagPlucker->pluck($tasks->toArray());
    }

}
