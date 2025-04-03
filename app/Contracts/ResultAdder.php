<?php

namespace App\Contracts;

use App\DTOs\AddResultDto;

interface ResultAdder
{
    public function add(AddResultDto $dto): void;
}
