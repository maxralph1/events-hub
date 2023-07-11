<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;

/**
 * @group User endpoints
 */
class TicketController extends Controller
{
    /**
     * GET Tickets
     *
     * Returns paginated list of tickets.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket_number":"01h3hkhxrh15atksjr11hrck0d20230123","event":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event","description":"This is the first event"},"ticket_type":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Ticket Type","description":"This is the first ticket type"},"added_by":"01h3hkhxrh15atksjr11hrck0d","amount_paid":12,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"USD"},"payment_confirmed":0,"payment_confirmed_by":"01h3hkhxrh15atksjr11hrck0d", ...}, ...}
     */
    public function index()
    {
        $tickets = auth()->user()->tickets()
            ->latest()
            ->paginate();

        return TicketResource::collection($tickets);
    }

    /**
     * POST Ticket
     *
     * Creates a new ticket record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket_number":"01h3hkhxrh15atksjr11hrck0d20230123","event":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event","description":"This is the first event"},"ticket_type":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Ticket Type","description":"This is the first ticket type"},"added_by":"01h3hkhxrh15atksjr11hrck0d","amount_paid":12,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"USD"},"payment_confirmed":0,"payment_confirmed_by":"01h3hkhxrh15atksjr11hrck0d", ...}, ...}
     * @response 422 {"message":"The added_by field is required.","errors":{"added_by":["The added_by field is required."]}, ...}
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->validated());

        return new TicketResource($ticket);
    }

    /**
     * GET Ticket
     *
     * Returns a ticket record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket_number":"01h3hkhxrh15atksjr11hrck0d20230123","event":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event","description":"This is the first event"},"ticket_type":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Ticket Type","description":"This is the first ticket type"},"added_by":"01h3hkhxrh15atksjr11hrck0d","amount_paid":12,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"USD"},"payment_confirmed":0,"payment_confirmed_by":"01h3hkhxrh15atksjr11hrck0d", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Ticket $ticket)
    {
        if ($ticket->user_id != auth()->id()) {
            abort(403);
        }

        return new TicketResource($ticket);
    }

    /**
     * DELETE Ticket
     *
     * Deletes ticket record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(Ticket $ticket)
    {
        if ($ticket->user_id != auth()->id()) {
            abort(403);
        }

        $ticket->delete();

        return response()->noContent();
    }
}
