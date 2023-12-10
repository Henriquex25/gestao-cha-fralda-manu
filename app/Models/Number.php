<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Number extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'payment_id',
    ];

    public function participant(): HasOneThrough
    {
        return $this->hasOneThrough(Participant::class, Payment::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->whereNull('payment_id');
    }

    public function scopeIsAvailable(Builder $query, int|array $numbers): Builder
    {
        $query->whereNull('payment_id');

        if (is_array($numbers)) {
            return $query->whereIn('id', $numbers);
        }

        return $query->where('id', $numbers);
    }

    public function isAvailable(): bool
    {
        return is_null($this->payment_id);
    }

    public function isNotAvailable(): bool
    {
        return !$this->isAvailable();
    }
}
