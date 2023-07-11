<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketTypeRequest;
use App\Http\Requests\UpdateTicketTypeRequest;
use App\Http\Resources\TicketTypeResource;
use App\Models\TicketType;

/**
 * @group Admin endpoints
 */
class TicketTypeController extends Controller
{
    /**
     * GET Ticket Types
     *
     * Returns paginated list of ticket types.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event","description":"This is the first event"},"title":"First event","slug":"first-event-sample","description":"This is the first event","available_tickets":200,"price":200,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"USD"}, ...}, ...}
     */
    public function index()
    {
        $ticketTypes = TicketType::withTrashed()
            ->latest()
            ->paginate();

        return TicketTypeResource::collection($ticketTypes);
    }

    /**
     * POST Ticket Type
     *
     * Creates a new ticket type record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event","description":"This is the first event"},"title":"First event","slug":"first-event-sample","description":"This is the first event","available_tickets":200,"price":200,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"USD"}, ...}, ...}
     * @response 422 {"message":"The title field is required.","errors":{"title":["The title field is required."]}, ...}
     */
    public function store(StoreTicketTypeRequest $request)
    {
        $ticketType = TicketType::create($request->validated());

        return new TicketTypeResource($ticketType);
    }

    /**
     * GET Ticket Type
     *
     * Returns a ticket type record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event","description":"This is the first event"},"title":"First event","slug":"first-event-sample","description":"This is the first event","available_tickets":200,"price":200,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"USD"}, ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(TicketType $ticketType)
    {
        return new TicketTypeResource($ticketType);
    }

    /**
     * PUT Ticket type
     *
     * Updates ticket type record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","event":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event","description":"This is the first event"},"title":"First event","slug":"first-event-sample","description":"This is the first event","available_tickets":200,"price":200,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"USD"}, ...}, ...}
     */
    public function update(UpdateTicketTypeRequest $request, TicketType $ticketType)
    {
        $ticketType->update($request->validated());

        return new TicketTypeResource($ticketType);
    }

    /**
     * DELETE Ticket Type
     *
     * Deletes ticket type record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();

        return response()->noContent();
    }
}
