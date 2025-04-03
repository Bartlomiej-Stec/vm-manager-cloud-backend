<?php

namespace App\Services;

use App\Models\Task;
use App\Contracts\TaskOutputAdder;

class TaskOutputAdderService implements TaskOutputAdder
{
    public function add(Task $task, string $output): void
    {
        $task->update([
            'output' => $output
        ]);
    }

}
