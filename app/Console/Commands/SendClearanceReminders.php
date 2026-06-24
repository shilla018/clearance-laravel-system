<?php

namespace App\Console\Commands;

use App\Mail\ClearanceDeadlineReminder;
use App\Models\ClearanceApplication;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendClearanceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearance:send-reminders {--days=3 : Days before deadline to send reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for clearance applications nearing deadline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');

        $targetDate = now()->addDays($days);
        $startOfDay = $targetDate->clone()->startOfDay();
        $endOfDay = $targetDate->clone()->endOfDay();

        // Find applications due in ~N days and not yet completed
        $applications = ClearanceApplication::where('status', 'pending')
            ->whereBetween('due_at', [$startOfDay, $endOfDay])
            ->get();

        $count = 0;

        foreach ($applications as $application) {
            if (!$application->student || !$application->student->email) {
                continue;
            }

            try {
                $daysRemaining = $application->due_at->diffInDays(now());

                Mail::to($application->student->email)->send(
                    new ClearanceDeadlineReminder($application, $daysRemaining)
                );

                $count++;
                $this->info("Reminder sent to {$application->student->email} for application #{$application->id}");
            } catch (\Exception $e) {
                $this->error("Failed to send reminder to {$application->student->email}: {$e->getMessage()}");
            }
        }

        $this->info("Sent {$count} reminder emails");
    }
}
