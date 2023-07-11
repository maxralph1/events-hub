<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

/**
 * @group Admin endpoints
 */
class UserController extends Controller
{
    /**
     * GET Users
     *
     * Returns paginated list of users.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","role_id":"01h3hkhxrh15atksjr11hrck0d","username":"user1","name":"John Snow","email":"john@snow.com", ...}, ...}
     */
    public function index()
    {
        $users = User::withTrashed()
            ->latest()
            ->paginate();

        return UserResource::collection($users);
    }

    /**
     * POST User
     *
     * Creates a new user record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","role_id":"01h3hkhxrh15atksjr11hrck0d","username":"user1","name":"John Snow","email":"john@snow.com", ...}, ...}
     * @response 422 {"message":"The name field is required.","errors":{"name":["The name field is required."]}, ...}
     */
    public function store(StoreUserRequest $request)
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

        return new UserResource($user);
    }

    /**
     * GET User
     *
     * Returns a user record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","role_id":"01h3hkhxrh15atksjr11hrck0d","username":"user1","name":"John Snow","email":"john@snow.com", ...}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * PUT User
     *
     * Updates user record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","role_id":"01h3hkhxrh15atksjr11hrck0d","username":"user1","name":"John Snow","email":"john@snow.com", ...}, ...}
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * DELETE User
     *
     * Deletes user record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
