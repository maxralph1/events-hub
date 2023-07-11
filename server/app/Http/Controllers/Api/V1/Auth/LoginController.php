<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @group Auth endpoints
 */
class LoginController extends Controller
{
    /**
     * POST Login
     *
     * Login with an existing user.
     *
     * @response {"access_token":"1|HvglYzIrLURVGx6Xe41HKj1CrNsxRxe4pLA2oISo","name":"John Snow","role":4}
     * @response 422 {"error": "The provided credentials are incorrect."}
     */
    public function __invoke(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'The provided credentials are incorrect.',
            ], 422);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
            'name' => $user->name,
            'role_id' => $user->role_id,
        ]);
    }
}
