<?php

namespace App\Livewire\Whatsapp;

use App\Enums\PaymentStatus;
use App\Jobs\SendMessageViaWhatsapp;
use App\Jobs\SendVideoViaWhatsapp;
use App\Models\Participant;
use App\Models\Winner;
use App\Services\WhatsApp\Facade\Whatsapp;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendMessage extends Component
{
    use WithFileUploads;

    #[Locked]
    public ?Winner $winner = null;

    #[Validate('required|min:2')]
    public string $message = 'Olá [name], Tudo bem?

Sou eu, a Manuh. Continuo crescendo muito no barrigão da mamãe e deixando cada dia mais meu papai de cabelo branco 🤭

Estou passando para agradecer sua participação no meu Chá Rifa. Papai e mamãe organizou com muita carinho.

[custom-message]

Obrigada pela participação e por todo o carinho ♥️';

    #[Locked]
    public string $messageToWinner = '*Estou passando para informar que seu número ([number]) foi sorteado 🥳🥳🥳*
    
Envie sua chave *PIX* para que o prêmio de R$ 200,00 seja realizado.';
    #[Locked]
    public string $messageToNonWinner = '*Infelizmente seu número não foi sorteado* 😕, mas saiba que você foi muito importante para a organização da minha chegada.';

    #[Validate('mimetypes:video/mp4|max:20480')]
    public $uploadedVideo;

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

    public function saveVideo(): void
    {
        $this->uploadedVideo->storeAs('videos', 'sorteio.mp4', 'public');
    }

    protected function injectParticipantInfoAndGetMessage(Participant $participant): string
    {
        $isWinner = $this->isWinner($participant);
        $participantFirstName = explode(' ', trim($participant->name))[0];
        $customMessage = $isWinner ? $this->messageToWinner : $this->messageToNonWinner;

        if ($isWinner) {
            $customMessage = str_replace('[number]', $this->winner->number_id, $customMessage);
        }

        $message = str_replace('[custom-message]', $customMessage, $this->message);
        $message = str_replace('[name]', $participantFirstName, $message);

        return $message;
    }

    public function sendMessage(): void
    {
        $this->saveVideo();

        Participant::query()
            ->whereRelation('payments', 'status', PaymentStatus::PAID)
            ->where('message_sent', false)
            ->each(function (Participant $participant) use (&$count) {
                $message = $this->injectParticipantInfoAndGetMessage($participant);

                SendVideoViaWhatsapp::dispatch($participant, $message);
            });


        Notification::make()
            ->success()
            ->title('Mensagens enviadas com sucesso!')
            ->send();
    }

    protected function isWinner($participant): bool
    {
        return $participant->id === $this->winner->participant_id;
    }

    public function render(): View
    {
        return view('livewire.whatsapp.send-message');
    }
}
