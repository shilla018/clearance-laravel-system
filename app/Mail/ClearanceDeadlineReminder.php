<?php

namespace App\Mail;

use App\Models\ClearanceApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClearanceDeadlineReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ClearanceApplication $clearanceApplication, public int $daysRemaining = 3)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: "⚠️ Onyo: Muda wa Uwazi Utaishia Sana - Siku {$this->daysRemaining} tu!",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.clearance-deadline-reminder',
            with: [
                'student' => $this->clearanceApplication->user,
                'application' => $this->clearanceApplication,
                'daysRemaining' => $this->daysRemaining,
                'dueDate' => $this->clearanceApplication->due_at?->format('d M Y H:i'),
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
