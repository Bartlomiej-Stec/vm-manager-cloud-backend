<?php

namespace App\Contracts;

use App\Models\Task;
use App\Models\User;

interface TaskDeleter
{
    public function deleteTask(Task $task, User $user): void;
}
