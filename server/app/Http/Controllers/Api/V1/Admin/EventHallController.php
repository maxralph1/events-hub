<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\EventHall;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventHallResource;
use App\Http\Requests\StoreEventHallRequest;
use App\Http\Requests\UpdateEventHallRequest;

class EventHallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventHalls = EventHall::withTrashed()
            ->latest()
            ->paginate();

        return EventHallResource::collection($eventHalls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventHallRequest $request)
    {
        $eventHall = EventHall::create($request->validated());

        return new EventHallResource($eventHall);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventHall $eventHall)
    {
        return new EventHallResource($eventHall);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventHallRequest $request, EventHall $eventHall)
    {
        $eventHall->update($request->validated());

        return new EventHallResource($eventHall);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventHall $eventHall)
    {
        $eventHall->delete();

        return response()->noContent();
    }
}
