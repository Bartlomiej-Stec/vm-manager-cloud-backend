<?php

namespace App\Services;

use App\Contracts\CodePublisher;
use App\Contracts\ServiceBusManager;
use App\ValueObjects\UserCodeObj;

class CodePublisherService implements CodePublisher
{
    public function __construct(
        private ServiceBusManager $serviceBusManager,
    ) {

    }

    private function createMessage(UserCodeObj $userCode): string
    {
        return json_encode($userCode->toArray());
    }

    public function publish(UserCodeObj $userCode): void
    {
        $message = $this->createMessage($userCode);
        $this->serviceBusManager->send($message);
    }

}
