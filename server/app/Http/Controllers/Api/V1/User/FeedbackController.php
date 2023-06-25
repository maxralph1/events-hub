<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\Feedback;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = auth()->user()->feedbacks()
            ->latest()
            ->paginate();

        return FeedbackResource::collection($feedbacks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedbackRequest $request)
    {
        $feedback = Feedback::create($request->validated());

        return new FeedbackResource($feedback);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        if ($feedback->user_id != auth()->id()) {
            abort(403);
        }

        return new FeedbackResource($feedback);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        if ($feedback->user_id != auth()->id()) {
            abort(403);
        }

        $feedback->delete();

        return response()->noContent();
    }
}