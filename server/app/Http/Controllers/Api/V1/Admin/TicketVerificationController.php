<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketVerificationRequest;
use App\Http\Requests\UpdateTicketVerificationRequest;
use App\Http\Resources\TicketVerificationResource;
use App\Models\TicketVerification;

/**
 * @group Admin endpoints
 */
class TicketVerificationController extends Controller
{
    /**
     * GET Ticket Verifications
     *
     * Returns paginated list of ticket verifications.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket_number":"01h3hkhxrh15SAMPLE","amount_paid":12,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"USD"}},"user":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","username":"user1"},"payment_confirmed":0, ...}, ...}
     */
    public function index()
    {
        $ticketVerifications = TicketVerification::withTrashed()
            ->latest()
            ->paginate();

        return TicketVerificationResource::collection($ticketVerifications);
    }

    /**
     * POST Ticket Verification
     *
     * Creates a new ticket verification record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket_number":"01h3hkhxrh15SAMPLE","amount_paid":12,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"USD"}},"user":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","username":"user1"},"payment_confirmed":0, ...}, ...}
     */
    public function store(StoreTicketVerificationRequest $request)
    {
        $ticketVerification = TicketVerification::create($request->validated());

        return new TicketVerificationResource($ticketVerification);
    }

    /**
     * GET Ticket Verification
     *
     * Returns a ticket verification record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket_number":"01h3hkhxrh15SAMPLE","amount_paid":12,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"USD"}},"user":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","username":"user1"},"payment_confirmed":0, ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(TicketVerification $ticketVerification)
    {
        return new TicketVerificationResource($ticketVerification);
    }

    /**
     * PUT Ticket Verification
     *
     * Updates ticket verification record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket":{"id":"01h3hkhxrh15atksjr11hrck0d","ticket_number":"01h3hkhxrh15SAMPLE","amount_paid":12,"currency":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"USD"}},"user":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","username":"user1"},"payment_confirmed":0, ...}, ...}
     */
    public function update(UpdateTicketVerificationRequest $request, TicketVerification $ticketVerification)
    {
        $ticketVerification->update($request->validated());

        return new TicketVerificationResource($ticketVerification);
    }

    /**
     * DELETE Ticket Verification
     *
     * Deletes ticket verification record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(TicketVerification $ticketVerification)
    {
        $ticketVerification->delete();

        return response()->noContent();
    }
}
