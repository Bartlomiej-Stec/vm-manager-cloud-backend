<?php

namespace App\Contracts;

use App\Models\Result;

interface AnswerDeleter
{
    public function delete(Result $result): void;
}
