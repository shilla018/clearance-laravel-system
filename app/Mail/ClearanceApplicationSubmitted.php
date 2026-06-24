<?php

namespace App\Mail;

use App\Models\ClearanceApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use Illuminate\Queue\SerializesModels;

class ClearanceApplicationSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ClearanceApplication $clearanceApplication)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Ombi la Uwazi Limetuma Successfully - Ref: ' . $this->clearanceApplication->id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.clearance-submitted',
            with: [
                'student' => $this->clearanceApplication->user,
                'application' => $this->clearanceApplication,
                'dueDate' => $this->clearanceApplication->due_at?->format('d M Y'),
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
