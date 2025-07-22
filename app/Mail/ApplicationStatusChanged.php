<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $status;
    public $rejection_reason;
    public $date;

    /**
     * Create a new message instance.
     */
    public function __construct(string $body, string $status, ?string $rejection_reason = null, string $date)
    {
        $this->body = $body;
        $this->status = $status;
        $this->rejection_reason = $rejection_reason;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Status Pendaftaran Anda Diperbarui',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.application_status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
