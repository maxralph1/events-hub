<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;

/**
 * @group Admin endpoints
 */
class FeedbackController extends Controller
{
    /**
     * GET Feedbacks
     *
     * Returns paginated list of feedbacks.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","added_by":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow"},"subject":"Feedback Subject","message":"This is the feedback message.", ...}, ...}
     */
    public function index()
    {
        $feedbacks = Feedback::withTrashed()
            ->latest()
            ->paginate();

        return FeedbackResource::collection($feedbacks);
    }

    /**
     * POST Feedback
     *
     * Creates a new feedback record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","added_by":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow"},"subject":"Feedback Subject","message":"This is the feedback message.", ...}, ...}
     * @response 422 {"message":"The subject field is required.","errors":{"subject":["The subject field is required."]}, ...}
     */
    public function store(StoreFeedbackRequest $request)
    {
        $feedback = Feedback::create($request->validated());

        return new FeedbackResource($feedback);
    }

    /**
     * GET Feedback
     *
     * Returns a feedback record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","added_by":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow"},"subject":"Feedback Subject","message":"This is the feedback message.", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(Feedback $feedback)
    {
        return new FeedbackResource($feedback);
    }

    /**
     * PUT Feedback
     *
     * Updates feedback record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","added_by":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow"},"subject":"Feedback Subject","message":"This is the feedback message.", ...}, ...}
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $feedback->update($request->validated());

        return new FeedbackResource($feedback);
    }

    /**
     * DELETE Feedback
     *
     * Deletes feedback record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return response()->noContent();
    }
}
