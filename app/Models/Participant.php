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
    ];

    protected function name(): Attribute
    {
        return Attribute::set(fn (string $name) => Str::ucfirst($name));
    }

    public function numbers(): HasManyThrough
    {
        return $this->hasManyThrough(Number::class, Payment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
