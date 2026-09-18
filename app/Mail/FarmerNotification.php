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

    public $notifType;
    public $notifSubject;
    public $notifMessage;
    public $officerName;
    public $district;
    public $farmerName;

    public function __construct($type, $subject, $message, $officerName, $district, $farmerName)
    {
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
}