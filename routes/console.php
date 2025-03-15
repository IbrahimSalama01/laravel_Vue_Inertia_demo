<?php

use App\Jobs\PruneOldPostsJob;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new PruneOldPostsJob)->dailyAt("00:00");


//* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1 but can't cause it's not linux;
/*

$Action = New-ScheduledTaskAction -Execute "php.exe" -Argument "artisan schedule:run" -WorkingDirectory "C:\path\to\your\laravel\project"

$Trigger = New-ScheduledTaskTrigger -Once -At (Get-Date) -RepetitionInterval (New-TimeSpan -Minutes 1)

$Settings = New-ScheduledTaskSettingsSet -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries -StartWhenAvailable

Register-ScheduledTask -TaskName "LaravelScheduler" -Action $Action -Trigger $Trigger -Settings $Settings -User "$env:UserName" -RunLevel Highest -Description "Runs Laravel scheduler every minute"
*/
