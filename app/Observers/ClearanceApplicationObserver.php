<?php

namespace App\Observers;

use App\Mail\ClearanceApplicationSubmitted;
use App\Models\ClearanceApplication;
use App\Models\ClearanceReview;
use Illuminate\Support\Facades\Mail;

class ClearanceApplicationObserver
{
    /**
     * Handle the ClearanceApplication "created" event.
     */
    public function created(ClearanceApplication $clearanceApplication): void
    {
        // Send email to student that application was submitted
        if ($clearanceApplication->student && $clearanceApplication->student->email) {
            Mail::to($clearanceApplication->student->email)
                ->send(new ClearanceApplicationSubmitted($clearanceApplication));
        }

        // Create clearance reviews for each department
        foreach (ClearanceApplication::DEPARTMENTS as $departmentKey => $departmentName) {
            ClearanceReview::create([
                'clearance_application_id' => $clearanceApplication->id,
                'department_key' => $departmentKey,
                'department_name' => $departmentName,
                'status' => 'pending',
                'comments' => 'Awaiting departmental review.',
            ]);
        }
    }

    /**
     * Handle the ClearanceApplication "updated" event.
     */
    public function updated(ClearanceApplication $clearanceApplication): void
    {
        // Check if status changed to completed
        if ($clearanceApplication->isDirty('completed_at') && $clearanceApplication->completed_at) {
            // Send completion email
            if ($clearanceApplication->student && $clearanceApplication->student->email) {
                // Final decision emails are handled by ClearanceReviewObserver.
            }
        }
    }

    /**
     * Handle the ClearanceApplication "deleted" event.
     */
    public function deleted(ClearanceApplication $clearanceApplication): void
    {
        //
    }

    /**
     * Handle the ClearanceApplication "restored" event.
     */
    public function restored(ClearanceApplication $clearanceApplication): void
    {
        //
    }

    /**
     * Handle the ClearanceApplication "force deleted" event.
     */
    public function forceDeleted(ClearanceApplication $clearanceApplication): void
    {
        //
    }
}
