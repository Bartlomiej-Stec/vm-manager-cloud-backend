<?php

namespace App\Contracts;

use App\Models\Task;

interface TaskGetter
{
    public function getTask(int $taskId, int $userId): Task;
}
