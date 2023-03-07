<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param \App\Services\UserRegistration $registration
     */
    public function __construct(protected UserRegistration $registration)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->user()->role == 'admin') {
            return UserResource::collection(User::all())->response();
        }
        else if ($request->user()->role == 'groupadmin') {
            return UserResource::collection(User::where('group_id', $request->user()->group_id)->get())->response();
        }
        else {
            return UserResource::collection(User::where('id', $request->user()->id)->get())->response();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        if ($request->user()->role == 'admin') {
            $group = $data['group_id'];
            $user = $this->registration->registerUser($data, 'participant', $group);
        }
        elseif ($request->user()->role == 'groupadmin') {
            $group = Auth::user()->group;
            $user = $this->registration->registerUser($data, 'participant', $group);
        }
        else {
            abort(401, 'You are not allowed to create new users');
        }
        return (new UserResource($user))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->all();
        $group = $this->registration->getGroup($data);
        $user = $this->registration->registerUser($data, 'groupadmin', $group);

        return (new UserResource($user))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        if (Auth::user()->role == 'admin' || Auth::user()->id == $user->id) {
            return (new UserResource($user))->response();
        }
        else if (Auth::user()->role == 'groupadmin' && Auth::user()->group_id == $user->group_id) {
            return (new UserResource($user))->response();
        }
        else {
            abort(401, 'You can only view your own profile');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $data = $this->registration->validateOnUserUpdate($request->all());
        if ($request->user()->role == 'admin' || $request->user()->id == $user->id) {
            $user->update($data);
        }
        else if ($request->user()->role == 'groupadmin' && $request->user()->group_id == $user->group_id) {
            $user->update($data);
        }
        else {
            abort(401, 'You can only edit your own profile');
        }
        return (new UserResource($user))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, User $user): JsonResponse
    {
        if ($user->role == 'admin' || $user->role == 'groupadmin') {
            abort(400, 'You can not delete an admin or groupadmin');
        }
        if ($request->user()->id == $user->id) {
            abort(400, 'You can not delete yourself');
        }
        else if ($request->user()->role == 'admin') {
            $user->delete();
        }
        else if ($request->user()->role == 'groupadmin' && $request->user()->group_id == $user->group_id) {
            $user->delete();
        }
        else {
            abort(401, 'You can only delete users from your own group');
        }
        return response()->json(null, 204);
    }
}
