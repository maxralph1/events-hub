<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\TicketVerification;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketVerificationResource;
use App\Http\Requests\StoreTicketVerificationRequest;
use App\Http\Requests\UpdateTicketVerificationRequest;

class TicketVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticketVerifications = TicketVerification::withTrashed()
            ->latest()
            ->paginate();

        return TicketVerificationResource::collection($ticketVerifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketVerificationRequest $request)
    {
        $ticketVerification = TicketVerification::create($request->validated());

        return new TicketVerificationResource($ticketVerification);
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketVerification $ticketVerification)
    {
        return new TicketVerificationResource($ticketVerification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketVerificationRequest $request, TicketVerification $ticketVerification)
    {
        $ticketVerification->update($request->validated());

        return new TicketVerificationResource($ticketVerification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketVerification $ticketVerification)
    {
        $ticketVerification->delete();

        return response()->noContent();
    }
}
