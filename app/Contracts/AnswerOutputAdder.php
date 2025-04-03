<?php

namespace App\Contracts;

use App\Models\Result;

interface AnswerOutputAdder
{   
    public function add(Result $result, string $output): void;
}
