<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Services\GroupRegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="group_id",
 *     in="path",
 *     name="id",
 *     description="Group ID",
 *     @OA\Schema(
 *         type="integer"
 *     )
 * )
 */
class GroupController extends Controller
{
    public function __construct(protected GroupRegistrationService $groupRegistration)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/groups",
     *     operationId="getGroupsList",
     *     tags={"Groups"},
     *     summary="Get list of Groups",
     *     security={{"sanctum": {}}},
     *     description="Returns list of Groups, if you are admin you will get all groups,
                if you are a groupadmin or participant you will get only your group",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Group")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->user()->role == 'admin') {
            return GroupResource::collection(Group::all())->response();
        } else {
            return GroupResource::collection(Group::where('id', $request->user()->group_id)->get())->response();
        }
    }

    /**
     * @OA\Post(
     *     path="/api/groups",
     *     operationId="storeGroup",
     *     tags={"Groups"},
     *     security={{"sanctum": {}}},
     *     summary="Create a new group (unsupported)",
     *     description="Currently, groups are created automatically when a user registers. This endpoint is disabled.",
     *     @OA\Response(
     *         response=400,
     *         description="You can only create groups via user registration",
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        abort(400, 'You can only create groups via user registration');
    }

    /**
     * @OA\Get(
     *     path="/api/groups/{id}",
     *     operationId="getGroupById",
     *     tags={"Groups"},
     *     security={{"sanctum": {}}},
     *     summary="Get a specific group",
     *     description="Admins can view all groups, groupadmins and participants can only view their own group",
     *     @OA\Parameter(
     *         ref="#/components/parameters/group_id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Group")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, you can only view your own group",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No query results for model Group {id}",
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function show(Request $request, Group $group): ?JsonResponse
    {
        if ($request->user()->role == 'admin' || $request->user()->group_id == $group->id) {
            return (new GroupResource($group))->response();
        } else {
            abort(403, 'You can only view your own group');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/groups/{id}",
     *     operationId="updateGroup",
     *     tags={"Groups"},
     *     security={{"sanctum": {}}},
     *     summary="Update group details",
     *     description="",
     *     @OA\Parameter(
     *         ref="#/components/parameters/group_id",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Group details",
     *         @OA\JsonContent(
     *             @OA\Property(property="organisation",      type="string", maxLength=255, description="Name of the organistion/group", example="Organization XYZ"),
     *             @OA\Property(property="website",           type="string", maxLength=255, description="Website of the organsiation", example="www.xyz-international.org"),
     *             @OA\Property(property="orgtype",           type="string", maxLength=255, description="Type of organisation", example="other"),
     *             @OA\Property(property="orgtypeother",      type="string", maxLength=255, description="Type of organisation", example="Government Agency"),
     *             @OA\Property(property="address",           type="string", maxLength=255, description="Street", example="Street 1"),
     *             @OA\Property(property="town",              type="string", maxLength=255, description="Town", example="Zurich"),
     *             @OA\Property(property="state",             type="string", maxLength=255, description="State", example="ZH"),
     *             @OA\Property(property="zipcode",           type="string", maxLength=255, description="Zipcode", example="12345"),
     *             @OA\Property(property="country",           type="string", maxLength=255, description="Country", example="CH"),
     *             @OA\Property(property="telephone",         type="string", maxLength=255, description="Telephone", example="123456789")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request, validation failed",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, you can only edit your own group and you need to be a groupadmin to edit a group",
     *     )
     * )
     *
     * @OA\Put(
     *     path="/api/groups/{id}",
     *     operationId="replaceGroup",
     *     tags={"Groups"},
     *     security={{"sanctum": {}}},
     *     summary="Replace group details",
     *     description="",
     *     @OA\Parameter(
     *         ref="#/components/parameters/group_id",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Group details",
     *         @OA\JsonContent(
     *             required={"organisation", "orgtype", "address", "town", "zipcode", "country", "telephone"},
     *             @OA\Property(property="organisation",      type="string", maxLength=255, description="Name of the organistion/group", example="Organization XYZ"),
     *             @OA\Property(property="website",           type="string", maxLength=255, description="Website of the organsiation", example="www.xyz-international.org"),
     *             @OA\Property(property="orgtype",           type="string", description="Type of organisation (Mission, Church, Education, Business, Non-Profit)", example="other"),
     *             @OA\Property(property="orgtypeother",      type="string", maxLength=255, description="Type of organisation", example="Government Agency"),
     *             @OA\Property(property="address",           type="string", maxLength=255, description="Street", example="Street 1"),
     *             @OA\Property(property="town",              type="string", maxLength=255, description="Town", example="Zurich"),
     *             @OA\Property(property="state",             type="string", maxLength=255, description="State", example="ZH"),
     *             @OA\Property(property="zipcode",           type="string", maxLength=255, description="Zipcode", example="12345"),
     *             @OA\Property(property="country",           type="string", maxLength=255, description="Country", example="CH"),
     *             @OA\Property(property="telephone",         type="string", maxLength=255, description="Telephone", example="123456789")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request, validation failed",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, you can only edit your own group and you need to be a groupadmin to edit a group",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No query results for model Group {id}",
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Group        $group
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Group $group): JsonResponse
    {
        if ($request->user()->role == 'admin'
            || $request->user()->role == 'groupadmin' && $request->user()->group_id == $group->id
        ) {
            try {
                $data = $this->validateBeforeUpdate($request, $group, $this->groupRegistration);
            } catch (\Exception $e) {
                abort(400, $e->getMessage());
            }
            $data['org_type'] = $data['orgtype'] == 'other' ? $data['orgtypeother'] : $data['orgtype'];
            $group->update($data);
            return (new GroupResource($group))->response();
        } else {
            abort(403, 'You can only edit your own group and you need to be a groupadmin to edit a group');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/groups/{id}",
     *     operationId="deleteGroup",
     *     tags={"Groups"},
     *     security={{"sanctum": {}}},
     *     summary="Delete group",
     *     description="Only admins can delete groups and only if there are no users in the group",
     *     @OA\Parameter(
     *         ref="#/components/parameters/group_id",
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, You can not delete this group",
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Group        $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Group $group): Response
    {
        if ($group->users->count() > 0) {
            abort(400, 'You can not delete a group with users');
        } elseif ($request->user()->role == 'groupadmin' && $group->id == $request->user()->group_id) {
            abort(400, 'You can not delete your own group');
        } elseif ($request->user()->role == 'admin') {
            $group->delete();
            return response(null, 204);
        } else {
            abort(403, 'You can not delete groups');
        }
    }
}
