<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * @group Auth endpoints
 */
class RegisterController extends Controller
{
    /**
     * POST Register
     *
     * Register with an existing user.
     *
     * @response {"access_token":"1|HvglYzIrLURVGx6Xe41HKj1CrNsxRxe4pLA2oISo","name":"John Snow","role":4}
     * @response 422 {"error": "The provided credentials are incorrect."}
     */
    public function __invoke(RegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('title', 'generic-user')->first()->id,
        ]);

        event(new Registered($user));

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
            'name' => $user->name,
            'role_id' => $user->role_id,
        ], Response::HTTP_CREATED);
    }
}
