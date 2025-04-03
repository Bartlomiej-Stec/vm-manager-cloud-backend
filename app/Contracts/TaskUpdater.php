<?php

namespace App\Contracts;

use App\Models\Task;
use App\DTOs\AddTaskDto;

interface TaskUpdater
{
    public function updateTask(Task $task, AddTaskDto $dto): void;
}
