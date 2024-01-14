<?php

namespace App\Livewire;

use App\Services\WhatsApp\Facade\Whatsapp;
use Livewire\Component;

class WhatsAppIndex extends Component
{
    public bool $connected         = false;
    public ?string $qrcodeInBase64 = null;

    public function mount()
    {
        $this->checkConnectionSession();
    }

    protected function checkConnectionSession(): bool
    {
        $response = Whatsapp::checkConnectionSession()->collect();

        $this->connected = $response->get('status');

        return $this->connected;
    }

    public function startSession(): void
    {
        $response = Whatsapp::startSession()
            ->collect();

        $this->qrcodeInBase64 = $response->get('qrcode');
    }

    public function render()
    {
        return view('livewire.whatsapp-index');
    }
}
