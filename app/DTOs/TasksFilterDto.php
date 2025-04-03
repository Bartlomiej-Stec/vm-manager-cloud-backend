<?php

namespace App\DTOs;

use App\Http\Requests\TasksFetchRequest;

readonly class TasksFilterDto
{
    public function __construct(
        public array $tags,
        public ?string $level,
        public ?string $search,
    ) {
    }

    public static function fromRequest(TasksFetchRequest $request): self
    {
        return new self(
            tags: $request->input('tags', []),
            level: $request->input('level'),
            search: $request->input('search'),
        );
    }
}
