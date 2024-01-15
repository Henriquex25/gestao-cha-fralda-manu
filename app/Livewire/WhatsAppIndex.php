<?php

namespace App\Livewire;

use App\Services\WhatsApp\Facade\Whatsapp;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class WhatsAppIndex extends Component
{
    use WithFileUploads;

    public bool $connected         = false;
    public ?string $qrcodeInBase64 = null;

    public function mount(): void
    {
        $this->checkConnectionSession();
    }

    public function checkConnectionSession(): bool
    {
        $response = Whatsapp::checkConnectionSession()->collect();

        $this->connected = $response->get('status');

        return $this->connected;
    }

    public function startSession(): void
    {
        $response = Whatsapp::startSession()
            ->collect();

        $this->qrcodeInBase64 = $response?->get('qrcode');
    }

    public function logoutSession(): void
    {
        Whatsapp::logoutSession();

        $this->checkConnectionSession();
    }

    public function render(): View
    {
        return view('livewire.whatsapp-index');
    }
}
