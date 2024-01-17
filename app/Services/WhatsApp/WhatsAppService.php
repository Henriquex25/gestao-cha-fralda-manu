<?php

declare(strict_types = 1);

namespace App\Services\WhatsApp;

use Illuminate\Http\Client\PendingRequest as Client;
use Illuminate\Http\Client\Response;

class WhatsAppService
{
    public function __construct(protected Client $client)
    {
        //
    }

    public function checkConnectionSession(): Response
    {
        $response = $this->client->get('/check-connection-session');

        return $response;
    }

    public function startSession()
    {
        $response = $this->client
            ->post('/start-session', [
                'webhook'    => route('whatsapp.webhook'),
                'waitQrCode' => true
            ]);

        return $response;
    }

    public function closeSession(): Response
    {
        $response = $this->client->post('/close-session');

        return $response;
    }

    public function logoutSession(): Response
    {
        $response = $this->client->post('/logout-session');

        return $response;
    }

    public function sendMessage(string $phone, string $message, bool $isGroup = false): Response
    {
        $response = $this->client->timeout(120)->post('/send-message', [
            "phone"   => trim($phone),
            "isGroup" => $isGroup,
            "message" => $message
        ]);

        return $response;
    }

    public function sendImageOrVideo(string $phone, string $fileName, string $path, ?string $message = null, bool $isGroup = false): Response
    {
        $response = $this->client->timeout(120)->post('/send-image', [
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
