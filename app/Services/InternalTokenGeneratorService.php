<?php

namespace App\Services;

use App\Models\InternalToken;
use App\Contracts\InternalTokenGenerator;

class InternalTokenGeneratorService implements InternalTokenGenerator
{
    public function generate(): string
    {
        $token = bin2hex(random_bytes(32));
        InternalToken::create(['token' => $token]);
        return $token;
    }

}
