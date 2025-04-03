<?php

namespace App\Contracts;

use App\ValueObjects\TaskUserAnswerObj;

interface UserTaskAnswerGetter
{
    public function get(int $userId, int $taskId): TaskUserAnswerObj;
}
