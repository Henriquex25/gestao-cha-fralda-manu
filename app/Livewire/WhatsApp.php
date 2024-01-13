<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class WhatsApp extends Component
{
    public function render()
    {
        return view('livewire.whatsapp');
    }

    // public function ()
    // {
    //     Http::withToken('$2b$10$Fk6Dm0Orq7ZyUB3DcRbwL.uYbJ.VrXQJTwgHbJ93uZoXMo9s7MCKm')
    //         ->withUrlParameters([
    //             'session' => 'gestao-cha-fralda-manu'
    //         ])
    //         ->get('http://localhost:21465/api/gestao-cha-fralda-manu/check-connection-session');
    // }
}
