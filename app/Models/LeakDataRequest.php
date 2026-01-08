<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeakDataRequest extends Model
{
    protected $fillable = [
        'user_id',
        'leak_check_log_id',
        'query',
        'full_name',
        'email',
        'phone_number',
        'reason',
        'department',
        'requester_status',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leakCheckLog(): BelongsTo
    {
        return $this->belongsTo(LeakCheckLog::class);
    }
}
