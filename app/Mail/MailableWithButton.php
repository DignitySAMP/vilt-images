<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailableWithButton extends Mailable
{
    use Queueable, SerializesModels;

    public string $title, $body, $url, $buttonText;
    /**
     * Create a new message instance.
     */
    public function __construct(string $title, string $body, string $url, string $buttonText)
    {
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
        $this->buttonText = $buttonText;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.mailable-with-button',
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
