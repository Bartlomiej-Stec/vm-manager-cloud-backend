<?php

namespace App\Contracts;

use App\Models\User;

interface PasswordUpdater
{
    public function update(string $password, User $user): void; 
}
