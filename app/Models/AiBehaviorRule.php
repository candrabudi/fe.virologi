<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiBehaviorRule extends Model
{
    protected $fillable = [
        'rule_name',
        'trigger_condition',
        'rule_description',
        'action',
        'examples',
        'priority',
        'is_active',
        'scope',
        // Existing columns if needed
        'intent_code',
        'pattern',
        'scope_code',
        'pattern_type',
        'pattern_value',
        'guided_kind',
        'decision',
    ];

    protected $casts = [
        'examples' => 'array',
        'priority' => 'integer',
        'is_active' => 'boolean',
    ];
}
