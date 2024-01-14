<?php

declare(strict_types = 1);

namespace App\Services\WhatsApp\Facade;

use Illuminate\Support\Facades\Facade;

class Whatsapp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'WhatsAppService';
    }
}
