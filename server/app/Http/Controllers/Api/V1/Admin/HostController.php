<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHostRequest;
use App\Http\Requests\UpdateHostRequest;
use App\Http\Resources\HostResource;
use App\Models\Host;

/**
 * @group Admin endpoints
 */
class HostController extends Controller
{
    /**
     * GET Hosts
     *
     * Returns paginated list of hosts.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","description":"John Snow is the king of pop.", ...}, ...}
     */
    public function index()
    {
        $hosts = Host::withTrashed()
            ->latest()
            ->paginate();

        return HostResource::collection($hosts);
    }

    /**
     * POST Host
     *
     * Creates a new host record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","description":"John Snow is the king of pop.", ...}, ...}
     * @response 422 {"message":"The name field is required.","errors":{"name":["The name field is required."]}, ...}
     */
    public function store(StoreHostRequest $request)
    {
        $host = Host::create($request->validated());

        return new HostResource($host);
    }

    /**
     * GET Host
     *
     * Returns a host record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","description":"John Snow is the king of pop.", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Host $host)
    {
        return new HostResource($host);
    }

    /**
     * PUT Host
     *
     * Updates host record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","description":"John Snow is the king of pop.", ...}, ...}
     */
    public function update(UpdateHostRequest $request, Host $host)
    {
        $host->update($request->validated());

        return new HostResource($host);
    }

    /**
     * DELETE Host
     *
     * Deletes host record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(Host $host)
    {
        $host->delete();

        return response()->noContent();
    }
}
