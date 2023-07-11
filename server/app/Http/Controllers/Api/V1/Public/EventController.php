<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\TicketResource;
use App\Models\Event;

/**
 * @group Public endpoints
 */
class EventController extends Controller
{
    /**
     * GET Events
     *
     * Returns paginated list of events.
     * 
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event_hall":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall."},"host":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Host"},"title":"First Event","slug":"first-event","description":"This is the first event","start_date":"2023-01-23","start_time":"01:23","end_date":"2023-01-23","end_time":"01:23","age_limit":"18", ...}, ...}
     */
    public function index()
    {
        $events = Event::withTrashed()
            ->latest()
            ->paginate();

        return EventResource::collection($events);
    }

    /**
     * GET Event
     *
     * Returns a event record.
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event_hall":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall."},"host":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Host"},"title":"First Event","slug":"first-event","description":"This is the first event","start_date":"2023-01-23","start_time":"01:23","end_date":"2023-01-23","end_time":"01:23","age_limit":"18", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * GET Ticket by Event
     *
     * Retrieves tickets by event record.
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket_number":"01h3hkhxrh15atksjr11hrck0d20230123","event":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event","description":"This is the first event"},"ticket_type":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Ticket Type","description":"This is the first ticket type"},"added_by":"01h3hkhxrh15atksjr11hrck0d","amount_paid":12,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"USD"},"payment_confirmed":0,"payment_confirmed_by":"01h3hkhxrh15atksjr11hrck0d", ...}, ...}
     */
    public function ticketsByEvent(Event $event)
    {
        $tickets = $event->tickets()
            ->orderBy('start_date')
            ->paginate();

        return TicketResource::collection($tickets);
    }
}
