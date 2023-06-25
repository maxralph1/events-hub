<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\TicketType;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketTypeResource;
use App\Http\Requests\StoreTicketTypeRequest;
use App\Http\Requests\UpdateTicketTypeRequest;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticketTypes = TicketType::withTrashed()
            ->latest()
            ->paginate();

        return TicketTypeResource::collection($ticketTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketTypeRequest $request)
    {
        $ticketType = TicketType::create($request->validated());

        return new TicketTypeResource($ticketType);
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketType $ticketType)
    {
        return new TicketTypeResource($ticketType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketTypeRequest $request, TicketType $ticketType)
    {
        $ticketType->update($request->validated());

        return new TicketTypeResource($ticketType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();

        return response()->noContent();
    }
}
