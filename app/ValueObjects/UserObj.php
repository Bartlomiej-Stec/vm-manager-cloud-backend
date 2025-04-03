<?php

namespace App\ValueObjects;

use App\Models\User;

class UserObj
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $surname,
        public string $created_at,
        public string $updated_at,
        public array $roles
    ) {

    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'surname' => $this->surname,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roles' => $this->roles
        ];
    }

    public static function fromModel(User $user): self
    {
        return new self(
            $user->id,
            $user->name,
            $user->email,
            $user->surname,
            $user->created_at,
            $user->updated_at,
            $user->roles->pluck('name')->toArray()
        );
    }
}
