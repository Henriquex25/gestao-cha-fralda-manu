<?php

namespace App\Livewire\Whatsapp;

use App\Services\WhatsApp\Facade\Whatsapp;
use Filament\Notifications\Notification;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendVideo extends Component
{
    use WithFileUploads;

    #[Validate('mimetypes:video/mp4|max:12288')]
    public $uploadedVideo;

    #[Validate('required|min:2')]
    public string $message = '';

    public function sendVideo(): void
    {
        // $this->uploadedVideo->store('video.mp4', 'public');

        $response = Whatsapp::sendImageOrVideo(
            phone: '5511959273990',
            fileName: 'video-cha-rifa-manuela',
            path: '/home/henrique/Projetos/gestao-cha-fralda-manu/storage/app/public/video.mp4',
            message: $this->message,
        )->collect();

        if ($response->get('status') !== 'success') {
            Notification::make()
                ->danger()
                ->title('Erro ao enviar o video!')
                ->body($response->get('message'))
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('Video enviado com sucesso!')
            ->send();
    }

    public function render()
    {
        return view('livewire.whatsapp.send-video');
    }
}
