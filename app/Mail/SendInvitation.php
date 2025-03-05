<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientName;
    public $meetingLink;


    /**
     * Create a new message instance.
     */
    public function __construct($recipientName, $meetingLink)
    {
        $this->recipientName = $recipientName;
        $this->meetingLink = $meetingLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Meeting Invitation',
        );
    }

    public function build()
    {
        return $this->subject('Join the Milaap Meeting Now')
            ->view('emails.meeting-invitation')
            ->with([
                'recipientName' => $this->recipientName,
                'meetingLink' => $this->meetingLink,
            ]);
    }
}
