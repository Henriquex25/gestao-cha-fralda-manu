<?php

declare(strict_types = 1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentType: string implements HasLabel
{
    case PIX    = 'pix';
    case DIAPER = 'fralda';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PIX    => 'Pix',
            self::DIAPER => 'Fralda',
        };
    }
}
