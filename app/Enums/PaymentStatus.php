<?php

declare(strict_types = 1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel, HasIcon, HasColor
{
    case PENDING = 'pendente';
    case PAID    = 'pago';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::PAID    => 'Pago',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::PAID    => 'heroicon-o-check-circle',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::PAID    => 'success',
        };
    }
}
