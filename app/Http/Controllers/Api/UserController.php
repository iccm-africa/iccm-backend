<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\GroupRegistrationService;
use App\Services\UserRegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="user_id",
 *     in="path",
 *     name="id",
 *     description="User ID",
 *     @OA\Schema(
 *         type="integer"
 *     )
 * )
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param \App\Services\UserRegistrationService  $userRegistration
     * @param \App\Services\GroupRegistrationService $groupRegistration
     */
    public function __construct(protected UserRegistrationService $userRegistration, protected GroupRegistrationService $groupRegistration)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     operationId="getUsersList",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     summary="Get list of users",
     *     description="Returns a list of registred users, if you are admin you will get all users, if you are a
               groupadmin you will get only user within your group. As a participant you will get only your user",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->user()->role == 'admin') {
            return UserResource::collection(User::all())->response();
        } elseif ($request->user()->role == 'groupadmin') {
            return UserResource::collection(User::where('group_id', $request->user()->group_id)->get())->response();
        } else {
            return UserResource::collection(User::where('id', $request->user()->id)->get())->response();
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     operationId="storeUserGroup",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     summary="Create a new user and add it to your group",
     *     description="If you are admin you can create a user within any group. If you are a groupadmin you can create
               a user within your group. As a participant you can not create a new user.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Registration details",
     *         @OA\JsonContent(
     *             required={"email", "accommodation_id", "name", "lastname", "residence"},
     *             @OA\Property(property="name",              type="string", maxLength=255, example="Bob"),
     *             @OA\Property(property="email",             type="string", format="email", description="User unique email address", example="user2@gmail.com"),
     *             @OA\Property(property="password",          type="string", maxLength=255, example="test12345"),
     *             @OA\Property(property="password_confirmation",           type="string", maxLength=255, example="test12345"),
     *             @OA\Property(property="lastname",          type="string", maxLength=255, example="Miller"),
     *             @OA\Property(property="nickname",          type="string", maxLength=255, example=""),
     *             @OA\Property(property="passport",          type="string", maxLength=255, description="Name on passport", example="Bob Miller"),
     *             @OA\Property(property="gender",            type="string", maxLength=1, example="m"),
     *             @OA\Property(property="residence",         type="string", maxLength=255, description="Country of residence", example="US"),
     *             @OA\Property(property="accommodation",     type="int", example="1")
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
     *         description="Validation error, see errors for more details",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, you are not allowed to create new users",
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        try {
            if ($request->user()->role == 'admin') {
                $group = $data['group_id'];
                $user = $this->userRegistration->registerUser($data, 'participant', $group);
            } elseif ($request->user()->role == 'groupadmin') {
                $group = Auth::user()->group;
                $user = $this->userRegistration->registerUser($data, 'participant', $group);
            } else {
                abort(403, 'You are not allowed to create new users');
            }
        } catch (ValidationException $e) {
            abort(400, $e->getMessage());
        }
        return (new UserResource($user))->response();
    }

    /**
     * @OA\Post(
     *     path="/api/users/register",
     *     operationId="storeUser",
     *     tags={"Users", "Groups", "Auth"},
     *     summary="Register as a new user and create your own group",
     *     description="This endpoint is used to register as a new user and create your own group of which you will be
               the groupadmin.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Registration details",
     *         @OA\JsonContent(
     *             required={"email", "accommodation_id", "name", "lastname", "residence", "organisation", "orgtype", "address", "town", "state", "zipcode", "country", "telephone"},
     *             @OA\Property(property="name",              type="string", maxLength=255, example="John"),
     *             @OA\Property(property="email",             type="string", format="email", description="User unique email address", example="user@gmail.com"),
     *             @OA\Property(property="password",          type="string", maxLength=255, example="test12345"),
     *             @OA\Property(property="password_confirmation",           type="string", maxLength=255, example="test12345"),
     *             @OA\Property(property="lastname",          type="string", maxLength=255, example="Doe"),
     *             @OA\Property(property="nickname",          type="string", maxLength=255, example="Johny"),
     *             @OA\Property(property="passport",          type="string", maxLength=255, description="Name on passport", example="John Doe"),
     *             @OA\Property(property="gender",            type="string", maxLength=1, example="m"),
     *             @OA\Property(property="residence",         type="string", maxLength=255, description="Country of residence", example="CH"),
     *             @OA\Property(property="accommodation",     type="int", example="1"),
     *             @OA\Property(property="organisation",      type="string", maxLength=255, description="Name of the organistion/group", example="Organization XYZ"),
     *             @OA\Property(property="website",           type="string", maxLength=255, description="Website of the organsiation", example="https://www.xyz-international.org"),
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
     *         description="Bad request, validation failed"
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->all();
        try {
            $user = $this->groupRegistration->registerGroup($data, 'groupadmin');
        } catch (ValidationException $e) {
            abort(400, $e->getMessage());
        }
        return (new UserResource($user))->response();
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     operationId="getUserById",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     summary="Get a specific user",
     *     description="Returns a specific user, if you are admin you will get any user, if you are a groupadmin you
               will get only user within your group. As a participant you will get only your user",
     *     @OA\Parameter(
     *         ref="#/components/parameters/user_id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, you can only view your own profile",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No query results for model User {id}",
     *     )
     * )
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        if (Auth::user()->role == 'admin' || Auth::user()->id == $user->id) {
            return (new UserResource($user))->response();
        } elseif (Auth::user()->role == 'groupadmin' && Auth::user()->group_id == $user->group_id) {
            return (new UserResource($user))->response();
        } else {
            abort(403, 'You can only view your own profile');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/users/{id}",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     summary="Update user",
     *     description="If you are admin you can update a user within any group. If you are a groupadmin
                you can update a user within your group. As a participant you can only update your own user.",
     *     @OA\Parameter(
     *         ref="#/components/parameters/user_id",
     *     ),
     *     @OA\RequestBody(
     *         request="User",
     *         required=true,
     *         description="Registration details",
     *         @OA\JsonContent(
     *             @OA\Property(property="name",              type="string", maxLength=255, example="Bob"),
     *             @OA\Property(property="email",             type="string", format="email", description="User unique email address", example="user2@gmail.com"),
     *             @OA\Property(property="password",          type="string", maxLength=255, example="test12345"),
     *             @OA\Property(property="password_confirmation",           type="string", maxLength=255, example="test12345"),
     *             @OA\Property(property="lastname",          type="string", maxLength=255, example="Miller"),
     *             @OA\Property(property="nickname",          type="string", maxLength=255, example=""),
     *             @OA\Property(property="passport",          type="string", maxLength=255, description="Name on passport", example="Bob Miller"),
     *             @OA\Property(property="gender",            type="string", maxLength=1, example="m"),
     *             @OA\Property(property="residence",         type="string", maxLength=255, description="Country of residence", example="US"),
     *             @OA\Property(property="accommodation",     type="int", example="1"),
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
     *         description="Forbidden, you can only edit your own profile or participants from your own group",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No query results for model User {id}",
     *     )
     * )
     *
     * @OA\Put(
     *     path="/api/users/{id}",
     *     operationId="replaceUser",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     summary="Update User",
     *     description="If you are admin you can update a user within any group. If you are a groupadmin
               you can update a user within your group. As a participant you can only update your own user.",
     *     @OA\Parameter(
     *         ref="#/components/parameters/user_id",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Registration details",
     *         @OA\JsonContent(
     *             required={"email", "accommodation_id", "name", "lastname", "residence"},
     *             @OA\Property(property="name",              type="string", maxLength=255, example="Bob"),
     *             @OA\Property(property="email",             type="string", format="email", description="User unique email address", example="user2@gmail.com"),
     *             @OA\Property(property="password",          type="string", maxLength=255, example="test12345"),
     *             @OA\Property(property="password_confirmation",           type="string", maxLength=255, example="test12345"),
     *             @OA\Property(property="lastname",          type="string", maxLength=255, example="Miller"),
     *             @OA\Property(property="nickname",          type="string", maxLength=255, example=""),
     *             @OA\Property(property="passport",          type="string", maxLength=255, description="Name on passport", example="Bob Miller"),
     *             @OA\Property(property="gender",            type="string", maxLength=1, example="m"),
     *             @OA\Property(property="residence",         type="string", maxLength=255, description="Country of residence", example="US"),
     *             @OA\Property(property="accommodation",     type="int", example="1"),
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
     *         description="Forbidden, you can only edit your own profile or participants from your own group",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No query results for model User {id}",
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User         $user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user): JsonResponse
    {
        try {
            $data = $this->validateBeforeUpdate($request, $user, $this->userRegistration);
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        if ($request->user()->role == 'admin' || $request->user()->id == $user->id) {
            $user->update($data);
        } elseif ($request->user()->role == 'groupadmin' && $request->user()->group_id == $user->group_id) {
            $user->update($data);
        } else {
            abort(403, 'You can only edit your own profile or participants from your own group');
        }
        return (new UserResource($user))->response();
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     summary="Delete user",
     *     description="If you are admin you can delete a user within any group. If you are a groupadmin
    you can delete any user within your group. As a participant you can not delete your own user.",
     *     @OA\Parameter(
     *         ref="#/components/parameters/user_id",
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
     *         description="Forbidden, you can only delete users from your own group",
     *     )
     * )
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
        } elseif ($request->user()->role == 'admin') {
            $user->delete();
        } elseif ($request->user()->role == 'groupadmin' && $request->user()->group_id == $user->group_id) {
            $user->delete();
        } else {
            abort(403, 'You can only delete users from your own group');
        }
        return response()->json(null, 204);
    }
}
