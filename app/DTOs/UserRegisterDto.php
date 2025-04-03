<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;

readonly class UserRegisterDto
{
    public function __construct(
        public string $name,
        public string $surname,
        public string $email,
        public string $password
    ) {

    }

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            surname: $request->input('surname'),
            email: $request->input('email'),
            password: Hash::make($request->get('password'))
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
