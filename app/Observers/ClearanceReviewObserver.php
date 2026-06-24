<?php

namespace App\Observers;

use App\Mail\ClearanceReviewDecision;
use App\Models\ClearanceReview;
use Illuminate\Support\Facades\Mail;

class ClearanceReviewObserver
{
    /**
     * Handle the ClearanceReview "updated" event.
     */
    public function updated(ClearanceReview $clearanceReview): void
    {
        // If status changed from pending to approved or denied
        if ($clearanceReview->wasChanged('status') &&
            $clearanceReview->getOriginal('status') === 'pending' &&
            in_array($clearanceReview->status, ['approved', 'denied']))
        {
            // Send email to student with review decision
            $student = $clearanceReview->clearanceApplication->student;

            if ($student && $student->email) {
                Mail::to($student->email)->send(
                    new ClearanceReviewDecision($clearanceReview)
                );
            }
        }
    }

    /**
     * Handle the ClearanceReview "created" event.
     */
    public function created(ClearanceReview $clearanceReview): void
    {
        //
    }

    /**
     * Handle the ClearanceReview "deleted" event.
     */
    public function deleted(ClearanceReview $clearanceReview): void
    {
        //
    }

    /**
     * Handle the ClearanceReview "restored" event.
     */
    public function restored(ClearanceReview $clearanceReview): void
    {
        //
    }

    /**
     * Handle the ClearanceReview "force deleted" event.
     */
    public function forceDeleted(ClearanceReview $clearanceReview): void
    {
        //
    }
}
