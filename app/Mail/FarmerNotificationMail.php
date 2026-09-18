<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FarmerNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $notifType;
    public string $notifSubject;
    public string $notifMessage;
    public string $officerName;
    public string $district;
    public string $farmerName;

    public function __construct(
        string $type,
        string $subject,
        string $message,
        string $officerName,
        string $district,
        string $farmerName
    ) {
        $this->notifType    = $type;
        $this->notifSubject = $subject;
        $this->notifMessage = $message;
        $this->officerName  = $officerName;
        $this->district     = $district;
        $this->farmerName   = $farmerName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[PaddyCare] ' . $this->notifSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.farmer-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}