<?php

namespace App\Contracts;

interface InternalTokenGenerator
{
    public function generate(): string;
}
