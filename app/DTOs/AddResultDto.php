<?php

namespace App\DTOs;

use App\Http\Requests\AddResultRequest;

readonly class AddResultDto
{
    public function __construct(
        public string $code,
        public int $taskId,
        public int $userId
    ) {

    }

    public static function fromRequest(AddResultRequest $request): self
    {
        return new self(
            code: $request->input('code'),
            taskId: $request->route('task')->id,
            userId: $request->user()->id
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'task_id' => $this->taskId,
            'user_id' => $this->userId
        ];
    }
}
