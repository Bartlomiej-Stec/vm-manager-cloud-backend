<?php

namespace App\Contracts;

use App\Models\Result;

interface MarkSetter
{
    public function setMark(Result $result, int $mark, int $userId): void;
}
