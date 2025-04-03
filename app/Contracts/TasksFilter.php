<?php

namespace App\Contracts;

use App\DTOs\TasksFilterDto;
use Illuminate\Database\Eloquent\Builder;

interface TasksFilter
{
    public function filter(Builder &$query, TasksFilterDto $dto): void;  
}
