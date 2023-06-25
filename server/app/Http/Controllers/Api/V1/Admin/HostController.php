<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Host;
use App\Http\Controllers\Controller;
use App\Http\Resources\HostResource;
use App\Http\Requests\StoreHostRequest;
use App\Http\Requests\UpdateHostRequest;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hosts = Host::withTrashed()
            ->latest()
            ->paginate();

        return HostResource::collection($hosts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHostRequest $request)
    {
        $host = Host::create($request->validated());

        return new HostResource($host);
    }

    /**
     * Display the specified resource.
     */
    public function show(Host $host)
    {
        return new HostResource($host);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHostRequest $request, Host $host)
    {
        $host->update($request->validated());

        return new HostResource($host);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Host $host)
    {
        $host->delete();

        return response()->noContent();
    }
}
