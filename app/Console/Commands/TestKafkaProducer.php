<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\KafkaPublisher;
use Junges\Kafka\Message\Message;

class TestKafkaProducer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:test';
    protected $description = 'Test Kafka connection and send a message';

    /**
     * Execute the console command.
     */
    public function handle(KafkaPublisher $kafkaPublisher)
    {
        echo $kafkaPublisher->publish('codes', 'Hello, Kafka!');
    }
}
