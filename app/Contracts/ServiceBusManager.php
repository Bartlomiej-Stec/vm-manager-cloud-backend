<?php

namespace App\Contracts;

interface ServiceBusManager
{
    public function send(string $message): bool;
}
