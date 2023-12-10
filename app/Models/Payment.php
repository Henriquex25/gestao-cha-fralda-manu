<?php

declare(strict_types = 1);

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'participant_id',
        'number_id',
        'payment_type',
        'observation',
        'status',
    ];

    protected $casts = [
        'status'       => PaymentStatus::class,
        'payment_type' => PaymentType::class,
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function numbers(): HasMany
    {
        return $this->hasMany(Number::class);
    }
}
