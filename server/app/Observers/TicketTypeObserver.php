<?php

namespace App\Observers;

use App\Models\TicketType;
use Illuminate\Support\Str;

class TicketTypeObserver
{
    /**
     * Handle the TicketType "creating" event.
     */
    public function creating(TicketType $ticketType): void
    {
        $ticketType->slug = str()->slug(
            Str::uuid()->getHex() .
                $ticketType->event->title .
                $ticketType->title
        );
    }
}
