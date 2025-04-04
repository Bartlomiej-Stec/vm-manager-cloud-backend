<?php

namespace App\Contracts;

interface KafkaPublisher
{
    public function publish(string $topic, string $message): bool;
}
