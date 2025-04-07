<?php

namespace App\Services;

use App\Models\Result;
use App\Contracts\AnswerOutputAdder;

class AnswerOutputAdderService implements AnswerOutputAdder
{
    private function isCorrect(?string $output, ?string $expectedOutput): bool
    {
        return $output == $expectedOutput;
    }

    public function add(Result $result, string $output): void
    {
        $result->update([
            'output' => $output,
            'is_correct' => $this->isCorrect($output, $result->task->output),
        ]);
    }

}
