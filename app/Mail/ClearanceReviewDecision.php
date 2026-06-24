<?php

namespace App\Mail;

use App\Models\ClearanceReview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClearanceReviewDecision extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ClearanceReview $review)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        $status = $this->review->status === 'approved' ? 'IMEKUBALI' : 'IMEKATAA';
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: "Clearance - Uamuzi wa {$this->review->department_name}: {$status}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.clearance-review-decision',
            with: [
                'student' => $this->review->clearanceApplication->user,
                'review' => $this->review,
                'application' => $this->review->clearanceApplication,
                'isApproved' => $this->review->status === 'approved',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
