<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @group Auth endpoints
 */
class LogoutController extends Controller
{
    /**
     * POST Logout
     *
     * Logout authenticated user.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
