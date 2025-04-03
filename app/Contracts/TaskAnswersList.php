<?php

namespace App\Contracts;

use App\Models\Task;
use App\Models\User;

interface TaskAnswersList
{
    public function get(Task $task, User $user): array;
}
