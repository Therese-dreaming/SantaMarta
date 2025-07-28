<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Mail\Mailable;

class TicketCreated extends Mailable
{
    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->markdown('emails.tickets.created')
                    ->subject('New Ticket Received');
    }
}