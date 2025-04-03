<?php

namespace App\Contracts;

use App\DTOs\AddTaskDto;

interface TaskAdder
{
    public function add(AddTaskDto $dto): void;
}
