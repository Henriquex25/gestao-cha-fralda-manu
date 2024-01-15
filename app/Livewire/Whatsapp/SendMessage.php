<?php

namespace App\Livewire\Whatsapp;

use App\Services\WhatsApp\Facade\Whatsapp;
use Filament\Notifications\Notification;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SendMessage extends Component
{
    #[Validate('required|min:10')]
    public string $winnerPhone = '';

    #[Validate('required|min:1')]
    public string $messageToWinner = '';

    public function sendMessage(): void
    {
        $response = Whatsapp::sendMessage($this->winnerPhone, $this->messageToWinner)->collect();

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
