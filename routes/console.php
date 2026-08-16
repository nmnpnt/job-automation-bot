<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('jobs:scrape')->twiceDaily(8, 20); // 8 AM and 8 PM
Schedule::command('app:check-emails')->hourly();
