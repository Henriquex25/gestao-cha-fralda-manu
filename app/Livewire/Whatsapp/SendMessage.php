<?php

namespace App\Livewire\Whatsapp;

use App\Models\Winner;
use App\Services\WhatsApp\Facade\Whatsapp;
use Filament\Notifications\Notification;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SendMessage extends Component
{
    #[Locked]
    public ?Winner $winner = null;

    #[Validate('required|min:2')]
    public string $message = '';

    public function mount(): void
    {
        $this->getWinner();
    }

    protected function getWinner(): void
    {
        $this->winner = Winner::query()
            ->with('participant')
            ->latest()
            ->first();
    }

    public function sendMessage(): void
    {
        $participantMobile = '55' . $this->winner->participant->mobile;

        // $response = Whatsapp::sendMessage($participantMobile, $this->message)->collect();
        $response = Whatsapp::sendMessage('5511959273990', $this->message)->collect();

        if ($response->get('status') !== 'success') {
            Notification::make()
                ->danger()
                ->title('Erro ao enviar a mensagem!')
                ->body($response->get('message'))
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('Mensagem enviada com sucesso!')
            ->send();
    }

    public function render()
    {
        return view('livewire.whatsapp.send-message');
    }
}
