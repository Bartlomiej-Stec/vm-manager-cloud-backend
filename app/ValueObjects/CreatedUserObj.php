<?php

namespace App\ValueObjects;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreatedUserObj
{
    public function __construct(
        public User $user,
        public string $token
    ) {

    }

    public static function fromModel(User $user): self
    {
        return new self(
            user: $user,
            token: JWTAuth::fromUser($user)
        );
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user,
            'token' => $this->token
        ];
    }
}


