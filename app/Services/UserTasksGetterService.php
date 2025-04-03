<?php
namespace App\Services;

use App\Models\Task;
use App\DTOs\TasksFilterDto;
use App\Contracts\TagPlucker;
use App\Contracts\TasksFilter;
use App\Contracts\UserTasksGetter;

class UserTasksGetterService implements UserTasksGetter
{
    private const ITEMS_PER_PAGE = 20;

    public function __construct(
        private TagPlucker $tagPlucker,
        private TasksFilter $tasksFilter
    ) {

    }

    public function get(int $userId, TasksFilterDto $dto): array
    {
        $query = Task::with('tags:task_id,name')
            ->select('title', 'id', 'level', 'content', 'input', 'created_at', 'updated_at', 'created_by')
            ->where('created_by', $userId);
        $this->tasksFilter->filter($query, $dto);
        $tasks = $query->orderBy('created_at', 'desc')
            ->paginate(self::ITEMS_PER_PAGE);
        return $this->tagPlucker->pluck($tasks->toArray());
    }
}
