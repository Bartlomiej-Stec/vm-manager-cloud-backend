<?php

namespace App\ValueObjects;

use App\Models\Result;

class TaskUserAnswerObj
{
    public function __construct(
        public string $code,
        public ?string $output,
        public ?bool $isCorrect,
        public ?int $mark
    ) {

    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'output' => $this->output,
            'is_correct' => $this->isCorrect,
            'mark' => $this->mark,
        ];
    }

    public static function fromModel(?Result $result): TaskUserAnswerObj
    {
        return new TaskUserAnswerObj(
            $result->code,
            $result->output,
            $result->is_correct,
            $result->mark
        );
    }
}
