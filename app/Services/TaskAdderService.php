<?php

namespace App\Services;

use App\Models\Task;
use App\Enums\CodeType;
use App\DTOs\AddTaskDto;
use App\Contracts\TagsAdder;
use App\Contracts\TaskAdder;
use App\Contracts\CodePublisher;
use App\ValueObjects\UserCodeObj;
use App\Contracts\InternalTokenGenerator;

class TaskAdderService implements TaskAdder
{
    public function __construct(
        private TagsAdder $tagsAdder,
        private InternalTokenGenerator $internalTokenGenerator,
        private CodePublisher $codePublisher
    ) {

    }

    public function add(AddTaskDto $dto): void
    {
        $task = Task::create($dto->toArray());
        $this->tagsAdder->add($dto->tags, $task->id);
        $internalToken = $this->internalTokenGenerator->generate();
        $this->codePublisher->publish(new UserCodeObj(
            code: $dto->code,
            token: $internalToken,
            type: CodeType::TASK_CORRECT_ANSWER->value,
            input: $dto->input,
            id: $task->id
        ));
    }

}
