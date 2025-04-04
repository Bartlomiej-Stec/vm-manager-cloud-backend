<?php

namespace App\Services;

use App\Contracts\CodePublisher;
use App\Contracts\KafkaPublisher;
use App\ValueObjects\UserCodeObj;

class CodePublisherService implements CodePublisher
{
    public function __construct(
        private KafkaPublisher $kafkaPublisher,
    ){

    }
    private const TOPIC = 'codes';

    private function createMessage(UserCodeObj $userCode): string
    {
        return json_encode($userCode->toArray());
    }

    public function publish(UserCodeObj $userCode): void
    {
        $message = $this->createMessage($userCode);
        $this->kafkaPublisher->publish(self::TOPIC, $message);
    }

}
