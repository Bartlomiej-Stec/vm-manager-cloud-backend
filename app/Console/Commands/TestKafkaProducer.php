<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
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
    public function handle()
    {
        try {
            // Prepare message
            $message = new Message(
                headers: ['header-key' => 'header-value'],
                body: ['key' => 'value'],
                key: 'kafka key here'  
            );
            $producer = Kafka::publish('broker:29092')
                ->onTopic('codes')
                ->withMessage($message);

            // Send message
            $producer->send();
            $this->info("Message sent to Kafka successfully!");
        } catch (\Exception $e) {
            $this->error("Failed to send message to Kafka: " . $e->getMessage());
        }
    }
}
