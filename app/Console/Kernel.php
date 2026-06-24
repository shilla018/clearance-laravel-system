<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send clearance deadline reminders daily at 8 AM
        $schedule->command('clearance:send-reminders --days=3')
            ->dailyAt('08:00')
            ->timezone('Africa/Dar_es_Salaam')
            ->name('clearance-reminders-3days')
            ->withoutOverlapping(5);

        // Send urgent reminders 1 day before deadline at 10 AM
        $schedule->command('clearance:send-reminders --days=1')
            ->dailyAt('10:00')
            ->timezone('Africa/Dar_es_Salaam')
            ->name('clearance-reminders-1day')
            ->withoutOverlapping(5);

        // Check and enforce deadline expiration
        $schedule->command('clearance:enforce-deadlines')
            ->hourly()
            ->timezone('Africa/Dar_es_Salaam')
            ->name('clearance-enforce-deadlines')
            ->withoutOverlapping(5);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
