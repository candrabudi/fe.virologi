<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiFeedback extends Model
{
    protected $table = 'ai_feedback';

    protected $fillable = [
        'chat_message_id',
        'user_id',
        'feedback_type',
        'rating',
        'comment',
        'suggested_improvement',
        'reviewed_by_admin',
        'applied_to_training',
    ];

    protected $casts = [
        'rating' => 'integer',
        'reviewed_by_admin' => 'boolean',
        'applied_to_training' => 'boolean',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(AiChatMessage::class, 'chat_message_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
