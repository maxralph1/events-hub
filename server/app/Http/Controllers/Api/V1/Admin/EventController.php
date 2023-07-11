<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\TicketResource;
use App\Models\Event;

/**
 * @group Admin endpoints
 */
class EventController extends Controller
{
    /**
     * GET Events
     *
     * Returns paginated list of events.
     * 
     * @authenticated
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
     * POST Event
     *
     * Creates a new event record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event_hall":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall."},"host":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Host"},"title":"First Event","slug":"first-event","description":"This is the first event","start_date":"2023-01-23","start_time":"01:23","end_date":"2023-01-23","end_time":"01:23","age_limit":"18", ...}, ...}
     * @response 422 {"message":"The title field is required.","errors":{"title":["The title field is required."]}, ...}
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());

        return new EventResource($event);
    }

    /**
     * GET Event
     *
     * Returns a event record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event_hall":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall."},"host":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Host"},"title":"First Event","slug":"first-event","description":"This is the first event","start_date":"2023-01-23","start_time":"01:23","end_date":"2023-01-23","end_time":"01:23","age_limit":"18", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * PUT Event
     *
     * Updates event record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event_hall":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall."},"host":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Host"},"title":"First Event","slug":"first-event","description":"This is the first event","start_date":"2023-01-23","start_time":"01:23","end_date":"2023-01-23","end_time":"01:23","age_limit":"18", ...}, ...}
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return new EventResource($event);
    }

    /**
     * DELETE Event
     *
     * Deletes event record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->noContent();
    }

    /**
     * PUT Event
     *
     * Updates event record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event_hall":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall."},"host":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Host"},"title":"First Event","slug":"first-event","description":"This is the first event","start_date":"2023-01-23","start_time":"01:23","end_date":"2023-01-23","end_time":"01:23","age_limit":"18", ...}, ...}
     */
    public function ticketsByEvent(Event $event)
    {
        $tickets = $event->tickets()
            ->orderBy('start_date')
            ->paginate();

        return TicketResource::collection($tickets);
    }
}
