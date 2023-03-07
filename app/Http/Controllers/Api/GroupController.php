<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->user()->role == 'admin') {
            return GroupResource::collection(Group::all())->response();
        }
        else {
            return GroupResource::collection(Group::where('id', $request->user()->group_id)->get())->response();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        abort(400, 'You can only create groups on registration');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function show(Request $request, Group $group): ?JsonResponse
    {
        if ($request->user()->role == 'admin' || $request->user()->group_id == $group->id) {
            return (new GroupResource($group))->response();
        }
        else {
            abort(401, 'You can only view your own group');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Group $group): JsonResponse
    {
        if ($request->user()->role == 'admin' ||
            $request->user()->role == 'groupadmin' && $request->user()->group_id == $group->id) {
            $group->update($request->all());
            return (new GroupResource($group))->response();
        }
        else {
            abort(401, 'You can only edit your own group');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Group $group): Response
    {
        if ($group->users->count() > 0) {
            abort(400, 'You can not delete a group with users');
        }
        else if ($request->user()->role == 'groupadmin' && $group->id == $request->user()->group_id) {
            abort(400, 'You can not delete your own group');
        }
        else if ($request->user()->role == 'admin') {
            $group->delete();
            return response(null, 204);
        }
        else {
            abort(401, 'You can not delete groups');
        }
    }
}
