<?php

namespace App\Mail;

use App\Models\Hiring;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HiringNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Hiring $hiring,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Anda Mendapatkan Tawaran Kerja Sama!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hiring-notification',
        );
    }
}
