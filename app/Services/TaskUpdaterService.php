<?php

namespace App\Services;

use App\Models\Task;
use App\DTOs\AddTaskDto;
use App\Contracts\TagsAdder;
use App\Contracts\TaskUpdater;
use App\Exceptions\TaskNoAccessException;

class TaskUpdaterService implements TaskUpdater
{
    public function __construct(
        private TagsAdder $tagsAdder
    ) {

    }

    public function updateTask(Task $task, AddTaskDto $dto): void
    {
        if ($dto->createdBy != $task->created_by) {
            throw new TaskNoAccessException('Task can be updated only by its creator', 403);
        }
        $task->update($dto->toArray());
        $this->tagsAdder->add($dto->tags, $task->id);
    }

}
