<?php

namespace App\Contracts;

use App\Models\Task;

interface TaskOutputAdder
{
    public function add(Task $task, string $output): void;
}
