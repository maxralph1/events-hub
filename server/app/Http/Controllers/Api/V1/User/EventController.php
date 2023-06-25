<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\TicketResource;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate();

        return EventResource::collection($events);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     */
    public function ticketsByEvent(Event $event)
    {
        $tickets = $event->tickets()
            ->orderBy('start_date')
            ->paginate();

        return TicketResource::collection($tickets);
    }
}
