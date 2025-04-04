<?php 

return [
    'broker' => env('KAFKA_BROKER', 'localhost:9092'),
    'security_protocol' => env('KAFKA_SECURITY_PROTOCOL', 'PLAINTEXT'),
    'mechanisms' => env('KAFKA_MECHANISMS', 'PLAIN'),
    'sasl_username' => env('KAFKA_SASL_USERNAME', ''),
    'sasl_password' => env('KAFKA_SASL_PASSWORD', ''),

];