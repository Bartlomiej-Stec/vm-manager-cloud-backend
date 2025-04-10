<?php

namespace App\Services;

use App\Contracts\ServiceBusManager;
use Illuminate\Support\Facades\Http;


class ServiceBusManagerService implements ServiceBusManager
{
    private function generateSasToken($uri, $sasKeyName, $sasKey): string
    {
        $encodedUri = rawurlencode(strtolower($uri));
        $expiry = time() + 3600;
        $stringToSign = $encodedUri . "\n" . $expiry;
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, $sasKey, true));
        $token = "SharedAccessSignature sr=$encodedUri&sig=" . rawurlencode($signature) . "&se=$expiry&skn=$sasKeyName";
        return $token;
    }

    public function send(string $message): bool
    {
        $namespace = config('service-bus.namespace');
        $queueName = config('service-bus.queue_name');
        $sasKeyName = config('service-bus.sas_key_name');
        $sasKey = config('service-bus.sas_key');
        $uri = "https://$namespace.servicebus.windows.net/$queueName/messages";
        $token = $this->generateSasToken($uri, $sasKeyName, $sasKey);
        $response = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type' => 'application/json;type=entry;charset=utf-8',
            'BrokerProperties' => json_encode(["TimeToLive" => 60]),
        ])->withBody($message, 'application/json')->post($uri);
        
        return $response->successful();
    }

}
