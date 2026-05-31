<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public string $nouveauStatut;

    public function __construct(Ticket $ticket, string $nouveauStatut)
    {
        $this->ticket = $ticket;
        $this->nouveauStatut = $nouveauStatut;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Mise à jour de votre demande #' . $this->ticket->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_status_updated',
        );
    }
}
