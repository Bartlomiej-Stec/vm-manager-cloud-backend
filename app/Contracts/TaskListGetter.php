<?php

namespace App\Contracts;

use App\DTOs\TasksFilterDto;

interface TaskListGetter
{
    public function getTasksList(TasksFilterDto $dto): array;
}
