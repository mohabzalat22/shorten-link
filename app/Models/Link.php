<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    protected $fillable = [
        'user_id',
        'url'
    ];

    public function shorten_links(): HasMany
    {
        return $this->hasMany(ShortenLink::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
