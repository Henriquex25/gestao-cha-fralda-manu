<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'message_sent',
        'video_sent',
    ];

    protected $casts = [
        'message_sent' => 'boolean',
        'video_sent'   => 'boolean',
    ];

    protected function name(): Attribute
    {
        return Attribute::set(fn(string $name) => Str::ucfirst($name));
    }

    protected function mobile(): Attribute
    {
        return Attribute::make(
            get: fn($number) => strlen($number) === 11 ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $number) : preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $number),
            set: fn($number) => preg_replace('/[^0-9]/', '', $number),
        );
    }

    public function numbers(): HasManyThrough
    {
        return $this->hasManyThrough(Number::class, Payment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isWinner(): bool
    {
        $winner = Winner::query()->latest()->first();

        return $this->id === $winner->participant_id;
    }
}
