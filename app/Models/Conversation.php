<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $casts = [
        'last_time_message' => 'datetime'
    ];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function userInstance(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->sender_id == Auth::id() ? $this->receiver : $this->user
        );
    }

    public function lastMessage(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->messages()->latest()->first()->body ?? ''
        );
    }
}
