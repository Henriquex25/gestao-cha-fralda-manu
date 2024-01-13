<?php

namespace App\Livewire;

use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class WhatsAppIndex extends Component
{
    protected WhatsAppService $whatsapp;

    public bool $connected         = false;
    public ?string $qrcodeInBase64 = null;

    public function mount()
    {
        $this->whatsapp = WhatsAppService::make();
        $this->checkConnectionSession();

        if (!$this->connected) {
            $this->startSession();
        }
    }

    protected function checkConnectionSession(): bool
    {
        $response = $this->whatsapp->checkConnectionSession()->collect();

        $this->connected = $response->get('status');

        return $this->connected;
    }

    protected function startSession(): void
    {
        $response = $this->whatsapp->startSession()->collect();

        $this->qrcodeInBase64 = $response->get('qrcode');
    }

    public function render()
    {
        return view('livewire.whatsapp-index');
    }

    // public function ()
    // {
    //     Http::withToken('$2b$10$Fk6Dm0Orq7ZyUB3DcRbwL.uYbJ.VrXQJTwgHbJ93uZoXMo9s7MCKm')
    //         ->withUrlParameters([
    //             'session' => 'gestao-cha-fralda-manu'
    //         ])
    //         ->get('http://localhost:21465/api/gestao-cha-fralda-manu/check-connection-session');
    // }
}
