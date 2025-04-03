<?php

namespace App\Contracts;

use App\ValueObjects\UserCodeObj;

interface CodePublisher
{
    public function publish(UserCodeObj $userCode): void;
}
