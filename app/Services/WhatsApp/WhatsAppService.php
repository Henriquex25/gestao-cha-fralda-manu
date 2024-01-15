<?php

declare(strict_types = 1);

namespace App\Services\WhatsApp;

use Illuminate\Http\Client\PendingRequest as Client;
use Illuminate\Http\Client\Response;

class WhatsAppService
{
    protected string $session;

    public function __construct(protected Client $client, ?string $session = null)
    {
        $this->session = $session ?: config('whatsapp.session');
    }

    public function checkConnectionSession(): Response
    {
        $endpoint = "{$this->session}/check-connection-session";
        $response = $this->client->get($endpoint);

        return $response;
    }

    public function startSession()
    {
        $endpoint = "{$this->session}/start-session";

        $response = $this->client
            ->post($endpoint, [
                'webhook' => route('whatsapp.webhook'),
                // 'webhook'    => 'https://api.webhookinbox.com/i/JFs7SEoB/in/',
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

    public function sendMessage(string $phone, string $message, bool $isGroup = false): Response
    {
        $endpoint = "{$this->session}/send-message";

        $response = $this->client->timeout(120)->post($endpoint, [
            "phone"   => trim($phone),
            "isGroup" => $isGroup,
            "message" => $message
        ]);

        return $response;
    }

    public function sendImageOrVideo(string $phone, string $fileName, string $path, ?string $message = null, bool $isGroup = false): Response
    {
        $endpoint = "{$this->session}/send-image";

        $response = $this->client->timeout(120)->post($endpoint, [
            "phone"    => $phone,
            "isGroup"  => $isGroup,
            "filename" => $fileName,
            'path'     => $path,
            "caption"  => $message,
            "base64"   => '',
        ]);

        return $response;
    }
}
