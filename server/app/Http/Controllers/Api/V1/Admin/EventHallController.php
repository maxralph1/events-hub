<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventHallRequest;
use App\Http\Requests\UpdateEventHallRequest;
use App\Http\Resources\EventHallResource;
use App\Models\EventHall;

/**
 * @group Admin endpoints
 */
class EventHallController extends Controller
{
    /**
     * GET Event Halls
     *
     * Returns paginated list of event halls.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall", ...}, ...}
     */
    public function index()
    {
        $eventHalls = EventHall::withTrashed()
            ->latest()
            ->paginate();

        return EventHallResource::collection($eventHalls);
    }

    /**
     * POST Event Hall
     *
     * Creates a new event hall record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall", ...}, ...}
     * @response 422 {"message":"The name field is required.","errors":{"name":["The name field is required."]}, ...}
     */
    public function store(StoreEventHallRequest $request)
    {
        $eventHall = EventHall::create($request->validated());

        return new EventHallResource($eventHall);
    }

    /**
     * GET Event Hall
     *
     * Returns a event hall record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(EventHall $eventHall)
    {
        return new EventHallResource($eventHall);
    }

    /**
     * PUT Event Hall
     *
     * Updates event hall record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"First Event Hall","description":"This is the first event hall", ...}, ...}
     */
    public function update(UpdateEventHallRequest $request, EventHall $eventHall)
    {
        $eventHall->update($request->validated());

        return new EventHallResource($eventHall);
    }

    /**
     * DELETE Event Hall
     *
     * Deletes event hall record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(EventHall $eventHall)
    {
        $eventHall->delete();

        return response()->noContent();
    }
}
