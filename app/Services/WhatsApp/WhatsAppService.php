<?php

declare(strict_types = 1);

namespace App\Services\WhatsApp;

use Illuminate\Http\Client\PendingRequest as Client;
use Illuminate\Http\Client\Response;

class WhatsAppService
{
    protected Client $client;

    protected string $session = '';

    public function __construct()
    {
        $this->makeClient();
        $this->getSession();
    }

    public static function make(): self
    {
        return new self();
    }

    private function makeClient(): void
    {
        $baseUrl   = config('whatsapp.base_url');
        $port      = config('whatsapp.port');
        $secretKey = config('whatsapp.secret_key');

        $this->client = (new Client)
            ->baseUrl("{$baseUrl}:{$port}/api")
            ->withToken($secretKey)
            ->withHeaders(['Content-Type' => 'application/json']);
    }

    private function getSession(): void
    {
        $this->session = config('whatsapp.session');
    }

    public function checkConnectionSession(): Response
    {
        $endpoint = "{$this->session}/check-connection-session";
        $response = $this->client->get($endpoint);

        return $response;
    }

    public function startSession(): Response
    {
        $endpoint = "{$this->session}/start-session";

        $response = $this->client
            ->post($endpoint, [
                // 'webhook'    => route('whatsapp.webhook'),
                'webhook'    => 'https://api.webhookinbox.com/i/SV4FFF8S/in/',
                'waitQrCode' => true
            ]);

        return $response;
    }

    public function closeSession(): Response
    {
        $endpoint = "{$this->session}/close-session";

        $response = $this->client->post($endpoint);

        return $response;
    }

    public function logoutSession(): Response
    {
        $endpoint = "{$this->session}/logout-session";

        $response = $this->client->post($endpoint);

        return $response;
    }
}
