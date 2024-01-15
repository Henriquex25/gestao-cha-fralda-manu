<?php

namespace App\Http\Controllers;

use App\Events\WhatsappQrCodeReadSuccess;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->has('event') && $request->event === 'status-find' && $request->status === 'qrReadSuccess') {
            WhatsappQrCodeReadSuccess::dispatch();
        }

        // logger()->info('evento que chegou', $request->all());
    }
}
