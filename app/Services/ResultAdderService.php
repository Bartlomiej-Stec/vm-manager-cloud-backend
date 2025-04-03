<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Result;
use App\Enums\CodeType;
use App\DTOs\AddResultDto;
use App\Contracts\ResultAdder;
use App\Contracts\CodePublisher;
use App\ValueObjects\UserCodeObj;
use App\Exceptions\AddResultException;
use App\Contracts\InternalTokenGenerator;


class ResultAdderService implements ResultAdder
{
    public function __construct(
        private InternalTokenGenerator $internalTokenGenerator,
        private CodePublisher $codePublisher
    ) {
    }

    private function isTaskCompleted(int $taskId, int $userId): bool
    {
        return Result::where('task_id', $taskId)->where('user_id', $userId)->exists();
    }

    private function isTaskCreator(int $taskId, int $userId): bool
    {
        return Task::find($taskId)->created_by === $userId;
    }

    public function add(AddResultDto $dto): void
    {
        if ($this->isTaskCompleted($dto->taskId, $dto->userId)) {
            throw new AddResultException('Task is already completed', 400);
        }

        if ($this->isTaskCreator($dto->taskId, $dto->userId)) {
            throw new AddResultException('You cannot add result to your own task', 403);
        }
        $result = Result::create($dto->toArray());
        $internalToken = $this->internalTokenGenerator->generate();
        $this->codePublisher->publish(new UserCodeObj(
            code: $dto->code,
            token: $internalToken,
            type: CodeType::USER_ANSWER->value,
            input: $result->task->input,
            id: $result->id
        ));
    }

}
