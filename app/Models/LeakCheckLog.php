<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeakCheckLog extends Model
{
    protected $fillable = [
        'user_id',
        'query',
        'leak_count',
        'raw_response',
        'status',
        'error_message',
        'ip_address',
    ];

    /**
     * Get the user that owns the log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the data requests for this log.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(LeakDataRequest::class);
    }
}
