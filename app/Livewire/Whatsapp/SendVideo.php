<?php

namespace App\Livewire\Whatsapp;

use App\Services\WhatsApp\Facade\Whatsapp;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendVideo extends Component
{
    use WithFileUploads;

    // #[Validate('mimetypes:video/mp4|max:12288')]
    public $uploadedVideo;

    public function sendVideo(): void
    {
        // $this->uploadedVideo->store();
        $response = Whatsapp::sendImageOrVideo(
            phone: '5511982081292',
            fileName: '',
            path: '/home/henrique/Projetos/wppconnect-server/uploads/video.mp4',
            message: 'Mensagem da foto...',
        )->collect();

        dd($response);
    }

    public function render()
    {
        return view('livewire.whatsapp.send-video');
    }
}
