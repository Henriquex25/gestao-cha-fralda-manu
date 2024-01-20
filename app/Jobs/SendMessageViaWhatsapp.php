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
use Illuminate\Queue\SerializesModels;

class SendMessageViaWhatsapp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Participant $participant,
        public string      $message,
    )
    {
        $this->connection = 'redis';
    }

    public function handle(): void
    {
        if ($this->participant->message_sent) {
            return;
        }

        $mobile = '11959273990';
//        $participantMobile = '55' . $this->participant->mobile;
        $participantMobile = '55' . $mobile;

        $response = Whatsapp::sendMessage(
            $participantMobile,
            $this->message
        )->collect();

        if ($response->get('status') === 'success') {
            $this->participant->video_sent = true;
            $this->participant->save();
        }
    }
}
