<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;

/**
 * @group Public endpoints
 */
class FeedbackController extends Controller
{
    /**
     * POST Feedback
     *
     * Creates a new feedback record.
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","added_by":{"id":"01h3hkhxrh15atksjr11hrck0d","name":"John Snow"},"subject":"Feedback Subject","message":"This is the feedback message.", ...}, ...}
     * @response 422 {"message":"The subject field is required.","errors":{"subject":["The subject field is required."]}, ...}
     */
    public function store(StoreFeedbackRequest $request)
    {
        $feedback = Feedback::create($request->validated());

        return new FeedbackResource($feedback);
    }
}
