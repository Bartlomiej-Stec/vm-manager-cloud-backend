<?php

namespace App\Contracts;

interface TagsAdder
{
    public function add(array $tags, int $taskId): void;
}
