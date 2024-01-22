<?php

namespace App\Jobs;

use App\Models\Participant;
use App\Models\Winner;
use App\Services\WhatsApp\Facade\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\RateLimiter;

class SendVideoViaWhatsapp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 0;

    public function __construct(
        public Participant $participant,
        public ?string     $message = null,
    )
    {
        $this->connection = 'redis';
    }

    public function middleware(): array
    {
        return [
            new RateLimited('whatsapp'),
        ];
    }

    public function handle(): void
    {
        if ($this->participant->message_sent) {
            return;
        }

        $participantMobile = '55' . preg_replace('/[^0-9]/', '', $this->participant->mobile);

        $response = Whatsapp::sendImageOrVideo(
            phone: $participantMobile,
            fileName: 'video-cha-rifa-manuela',
            path: 'http://192.168.0.7/storage/videos/sorteio.mp4',
            message: $this->message,
        )->collect();

        if ($response->get('status') === 'success') {
            $this->participant->message_sent = true;
            $this->participant->save();
        }
    }
}
