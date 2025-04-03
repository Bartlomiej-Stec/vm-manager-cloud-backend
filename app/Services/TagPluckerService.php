<?php

namespace App\Services;

use App\Contracts\TagPlucker;

class TagPluckerService implements TagPlucker
{
    public function pluck(array $tasks): array
    {
        foreach ($tasks['data'] as &$task) {
            $task['tags'] = array_map(function ($tag) {
                return $tag['name'];
            }, $task['tags']);
        }
        return $tasks;
    }

}
