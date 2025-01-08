<?php

use App\Console\Commands\SummaryRevenue;
use App\Console\Commands\TestCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(SummaryRevenue::class, [])->monthlyOn(1, '01:00');
// Schedule::command(TestCommand::class, [])->hourly();
