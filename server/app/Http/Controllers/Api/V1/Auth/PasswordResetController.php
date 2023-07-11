<?php

namespace App\Http\Controllers\Api\V1\Auth;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * @group Auth endpoints
 */
class PasswordResetController extends Controller
{
    /**
     * PUT Reset Password
     *
     * Reset Password of an existing user.
     * 
     * @authenticated
     *
     * @response {"success":"Your password has been updated."}
     */
    public function __invoke(PasswordResetRequest $request)
    {
        $request->validated();

        auth()->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'success' => 'Your password has been updated.',
        ], Response::HTTP_ACCEPTED);
    }
}
