<?php

namespace App\Services;

use Junges\Kafka\Facades\Kafka;
use App\Contracts\CodePublisher;
use App\ValueObjects\UserCodeObj;
use Junges\Kafka\Message\Message;

class CodePublisherService implements CodePublisher
{
    private const TOPIC = 'codes';

    private function createMessage(UserCodeObj $userCode): Message
    {
        return new Message(
            body: $userCode->toArray(),
        );
    }

    public function publish(UserCodeObj $userCode): void
    {
        $message = $this->createMessage($userCode);
        $producer = Kafka::publish(config('kafka.brokers'))->onTopic(self::TOPIC)->withMessage($message);
        $producer->send();
    }

}
