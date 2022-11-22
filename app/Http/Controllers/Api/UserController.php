<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\{ IndexUser, ShowUser, StoreUser, UpdateUser, DestroyUser };
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Display a listing of the users.
     *
     * @param  \App\Http\Requests\Api\User\IndexUser  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexUser $request)
    {
        $query = User::select();

        $users = $query->paginate($request->input('per_page') ?? null)->appends(request()->query());

        return UserResource::collection($users);
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Requests\Api\User\ShowUser  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, ShowUser $request)
    {
        return new UserResource($user->load('documents'));
    }

    /**
     * Register a new user
     *
     * @param  \App\Http\Requests\Api\User\StoreUser  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $fields = $request->validated();
        $user = User::create($fields)->fresh();

        return new UserResource($user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Requests\Api\User\UpdateUser  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUser $request)
    {
        $fields = $request->validated();

        $user->fill($fields);
        $user->save();

        return new UserResource($user->fresh());
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Requests\Api\User\DestroyUser  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, DestroyUser $request)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
