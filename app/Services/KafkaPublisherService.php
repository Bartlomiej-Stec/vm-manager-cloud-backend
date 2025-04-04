<?php

namespace App\Services;

use RdKafka\Conf;
use RdKafka\Producer;
use App\Contracts\KafkaPublisher;



class KafkaPublisherService implements KafkaPublisher
{
    private function getConf(): Conf
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', config('kafka.broker'));
        $conf->set('security.protocol', config('kafka.security_protocol'));
        $conf->set('sasl.mechanisms', config('kafka.mechanisms'));
        $conf->set('sasl.username', config('kafka.sasl_username'));
        $conf->set('sasl.password', config('kafka.sasl_password'));
        return $conf;
    }

    public function publish(string $topic, string $message): bool
    {
        $rk = new Producer($this->getConf());
        $topic = $rk->newTopic($topic);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        $rk->poll(0);
        $result = $rk->flush(10000);
        return $result === RD_KAFKA_RESP_ERR_NO_ERROR;
    }

}
