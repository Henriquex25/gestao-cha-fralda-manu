<?php

return [
    'session'    => env('WHATSAPP_SESSION', config('app.name')),
    'base_url'   => env('WHATSAPP_BASE_URL'),
    'port'       => env('WHATSAPP_PORT', '21465'),
    'secret_key' => env('WHATSAPP_SECRET_KEY'),
];
