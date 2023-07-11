<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;

/**
 * @group Admin endpoints
 */
class TagController extends Controller
{
    /**
     * GET Tags
     *
     * Returns paginated list of tags.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"Karaoke","description":"This is the regular karaoke.", ...}, ...}
     */
    public function index()
    {
        $tags = Tag::withTrashed()
            ->latest()
            ->paginate();

        return TagResource::collection($tags);
    }

    /**
     * POST Tag
     *
     * Creates a new tag record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"Karaoke","description":"This is the regular karaoke.", ...}, ...}
     * @response 422 {"message":"The title field is required.","errors":{"title":["The title field is required."]}, ...}
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->validated());

        return new TagResource($tag);
    }

    /**
     * GET Tag
     *
     * Returns a tag record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"Karaoke","description":"This is the regular karaoke.", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    /**
     * PUT Tag
     *
     * Updates tag record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","title":"Karaoke","description":"This is the regular karaoke.", ...}, ...}
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return new TagResource($tag);
    }

    /**
     * DELETE Tag
     *
     * Deletes tag record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->noContent();
    }
}
