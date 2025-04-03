<?php

namespace App\Contracts;

use App\DTOs\TasksFilterDto;

interface UserTasksGetter
{
    public function get(int $userId, TasksFilterDto $dto): array;
}
