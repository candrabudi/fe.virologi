<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiTrainingData extends Model
{
    protected $table = 'ai_training_data';

    protected $fillable = [
        'category',
        'question',
        'ideal_answer',
        'context',
        'metadata',
        'is_approved',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
