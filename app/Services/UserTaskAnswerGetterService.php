<?php

namespace App\Services;

use App\Models\Result;
use App\Contracts\UserTaskAnswerGetter;
use App\ValueObjects\TaskUserAnswerObj;
use App\Exceptions\UserOwnTaskAnswerNotFoundException;

class UserTaskAnswerGetterService implements UserTaskAnswerGetter
{
    public function get(int $userId, int $taskId): TaskUserAnswerObj
    {
        $answer = Result::where('user_id', $userId)
            ->where('task_id', $taskId)
            ->first();
        if(!$answer) {
            throw new UserOwnTaskAnswerNotFoundException('User answer not found', 404);
        }
        return TaskUserAnswerObj::fromModel($answer);
    }

}
