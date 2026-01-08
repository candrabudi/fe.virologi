<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_logo',
        'site_logo_footer',
        'site_favicon',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'google_analytics_id',
        'google_console_verification',
        'custom_head_scripts',
        'custom_body_scripts',
    ];
}
