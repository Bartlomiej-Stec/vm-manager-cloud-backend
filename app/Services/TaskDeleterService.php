<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Contracts\TaskDeleter;
use App\Exceptions\TaskNoAccessException;

class TaskDeleterService implements TaskDeleter
{
    public function deleteTask(Task $task, User $user): void
    {
        if ($task->created_by !== $user->id && !$user->hasPermissionTo('delete tasks')) {
            throw new TaskNoAccessException('Task can be updated only by its creator', 403);
        }
        $task->delete();
    }

}
