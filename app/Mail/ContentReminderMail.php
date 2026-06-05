<?php

namespace App\Mail;

use App\Models\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content as MailContent;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Content $content,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Tenggat Waktu Konten',
        );
    }

    public function content(): MailContent
    {
        return new MailContent(
            view: 'emails.content-reminder',
        );
    }
}
