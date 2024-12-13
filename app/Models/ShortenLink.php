<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShortenLink extends Model
{
    protected $fillable = [
        'link_id',
        'url',
        'accessCount'
    ];

    public function link() : BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
