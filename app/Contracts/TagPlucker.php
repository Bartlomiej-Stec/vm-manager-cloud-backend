<?php

namespace App\Contracts;

interface TagPlucker
{
    public function pluck(array $tasks): array;
}
