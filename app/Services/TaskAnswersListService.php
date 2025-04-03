<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Result;
use App\Contracts\TaskAnswersList;
use App\Exceptions\AnswerAccessException;

class TaskAnswersListService implements TaskAnswersList
{
    private const ITEMS_PER_PAGE = 20;
    public function get(Task $task, User $user): array
    {
        if ($task->created_by !== $user->id && !$user->hasPermissionTo('delete answers')) {
            throw new AnswerAccessException('You cannot access answers of this task', 403);
        }

        return Result::select('id', 'user_id', 'code', 'output', 'is_correct', 'mark', 'created_at', 'updated_at')
            ->with('user:id,name,surname')
            ->where('task_id', $task->id)
            ->orderBy('created_at', 'desc')
            ->paginate(self::ITEMS_PER_PAGE)
            ->through(function ($answer) {
                unset($answer->user_id);
                return $answer;
            })
            ->toArray();
    }

}
