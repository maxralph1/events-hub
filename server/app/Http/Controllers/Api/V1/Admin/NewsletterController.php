<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Newsletter;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsletterResource;
use App\Http\Requests\StoreNewsletterRequest;
use App\Http\Requests\UpdateNewsletterRequest;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsletters = Newsletter::withTrashed()
            ->latest()
            ->paginate();

        return NewsletterResource::collection($newsletters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsletterRequest $request)
    {
        $newsletter = Newsletter::create($request->validated());

        return new NewsletterResource($newsletter);
    }

    /**
     * Display the specified resource.
     */
    public function show(Newsletter $newsletter)
    {
        return new NewsletterResource($newsletter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsletterRequest $request, Newsletter $newsletter)
    {
        $newsletter->update($request->validated());

        return new NewsletterResource($newsletter);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return response()->noContent();
    }
}
