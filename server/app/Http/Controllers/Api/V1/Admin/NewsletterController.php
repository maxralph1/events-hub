<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsletterRequest;
use App\Http\Requests\UpdateNewsletterRequest;
use App\Http\Resources\NewsletterResource;
use App\Models\Newsletter;

/**
 * @group Admin endpoints
 */
class NewsletterController extends Controller
{
    /**
     * GET Newsletters
     *
     * Returns paginated list of newsletters.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","email":"john@snow.com", ...}, ...}
     */
    public function index()
    {
        $newsletters = Newsletter::withTrashed()
            ->latest()
            ->paginate();

        return NewsletterResource::collection($newsletters);
    }

    /**
     * POST Newsletter
     *
     * Creates a new newsletter record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","email":"john@snow.com", ...}, ...}
     * @response 422 {"message":"The name field is required.","errors":{"name":["The name field is required."]}, ...}
     */
    public function store(StoreNewsletterRequest $request)
    {
        $newsletter = Newsletter::create($request->validated());

        return new NewsletterResource($newsletter);
    }

    /**
     * GET Newsletter
     *
     * Returns a newsletter record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","email":"john@snow.com", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Newsletter $newsletter)
    {
        return new NewsletterResource($newsletter);
    }

    /**
     * PUT Newsletter
     *
     * Updates newsletter record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow","email":"john@snow.com", ...}, ...}
     */
    public function update(UpdateNewsletterRequest $request, Newsletter $newsletter)
    {
        $newsletter->update($request->validated());

        return new NewsletterResource($newsletter);
    }

    /**
     * DELETE Newsletter
     *
     * Deletes newsletter record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return response()->noContent();
    }
}
