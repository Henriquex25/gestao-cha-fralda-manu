<?php

declare(strict_types = 1);

namespace App\Services\WhatsApp;

class WhatsApp
{
    protected string $session = '';

    public function __construct()
    {
        $this->session = config('whatsapp.session');
    }
}
