<?php

namespace App\ValueObjects;

class UserCodeObj
{
    public function __construct(
        public string $code,
        public string $token,
        public string $type,
        public ?string $input,
        public int $id
    ) {

    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'token' => $this->token,
            'type' => $this->type,
            'input' => $this->input,
            'id' => $this->id
        ];
    }
}
