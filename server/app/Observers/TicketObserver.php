<?php

namespace App\Observers;

use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketObserver
{
    /**
     * Handle the Ticket "creating" event.
     */
    public function creating(Ticket $ticket): void
    {
        // $ticket->ticket_number = Str::uuid()->getHex();

        $ticket->ticket_number = str(
            $ticket->event->title .
                $ticket->ticket_type->title .
                $ticket->id .
                Str::uuid()->getHex() .
                now()->format('YmdHis')
        )->slug();

        // $ticket->currency_id = $ticket->ticket_type->currency->id;
    }
}
