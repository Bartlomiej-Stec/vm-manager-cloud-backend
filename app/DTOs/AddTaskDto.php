<?php

namespace App\DTOs;

use App\Http\Requests\AddTaskRequest;

readonly class AddTaskDto
{
    public function __construct(
        public string $title,
        public string $content,
        public string $level,
        public ?string $input,
        public string $code,
        public array $tags,
        public int $createdBy
    ) {

    }

    public static function fromRequest(AddTaskRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            content: $request->input('content'),
            level: $request->input('level'),
            input: $request->input('input'),
            code: $request->input('code'),
            tags: $request->input('tags', []),
            createdBy: $request->user()->id
        );  
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'level' => $this->level,
            'input' => $this->input,
            'code' => $this->code,
            'created_by' => $this->createdBy
        ];
    }
}
