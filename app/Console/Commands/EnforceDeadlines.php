<?php

namespace App\Console\Commands;

use App\Models\ClearanceApplication;
use App\Models\SystemNotification;
use Illuminate\Console\Command;

class EnforceDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearance:enforce-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enforce clearance deadlines - mark expired applications as failed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find pending applications with expired due_at
        $expiredApplications = ClearanceApplication::where('status', 'pending')
            ->where('due_at', '<', now())
            ->get();

        $count = 0;

        foreach ($expiredApplications as $application) {
            // Mark as denied/failed due to deadline
            $application->update([
                'status' => 'denied',
                'completed_at' => now(),
                'metadata' => array_merge(
                    $application->metadata ?? [],
                    ['deadline_expired_at' => now()->toDateTimeString()]
                ),
            ]);

            $count++;

            // Create notification for student
            if ($application->student) {
                SystemNotification::create([
                    'user_id' => $application->student->id,
                    'title' => 'Ombi Lako la Uwazi Limechelewa',
                    'message' => 'Muda wa ombi lako Nambari ' . $application->id . ' umechelewa. Tafadhali wasiliana na timu ya msaada.',
                    'type' => 'clearance',
                    'action_url' => '/dashboard/clearance',
                ]);
            }

            $this->info("Expired application #{$application->id} for {$application->student?->name ?? 'Unknown'}");
        }

        $this->info("Processed {$count} expired applications");
    }
}
