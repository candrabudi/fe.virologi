<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

// AI Autonomous Research: Learn a new topic every hour
Schedule::command('ai:discover --limit=1')->hourly()->withoutOverlapping();

// AI Auto-Learn from interactions: Process feedback daily
Schedule::command('ai:autolearn')->dailyAt('02:00')->withoutOverlapping();
