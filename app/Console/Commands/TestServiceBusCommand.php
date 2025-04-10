<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\ServiceBusManager;
use Illuminate\Support\Facades\Http;

class TestServiceBusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:service-bus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test service bus connection and send a message';

    

    /**
     * Execute the console command.
     */
    public function handle(ServiceBusManager $serviceBusManager): void
    {
        echo $serviceBusManager->send('Hello, Service Bus!');
    }
}
