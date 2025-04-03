<?php

namespace App\Services;

use App\Models\Task;
use App\Contracts\TaskGetter;

class TaskGetterService implements TaskGetter
{
    public function getTask(int $taskId, int $userId): Task
    {
        $task = Task::with(['user:id,name,surname'])
            ->where('id', $taskId)
            ->first();
        if ($task) {
            $tags = $task->tags()->pluck('name')->toArray();
            if ($task->created_by !== $userId) {
                $task->code = null;
                $task->output = null;
            }
            $task->created_by = $task->user;
            unset($task->user);
            $task->tags = $tags;
        }

        return $task;
    }


}
