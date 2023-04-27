<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostRegistrationResource;
use App\Models\PostRegistration;
use App\Models\User;
use App\Services\PostRegistrationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="postregistration_id",
 *     in="path",
 *     name="Post Registration ID",
 *     description="The ID of the Post Registration",
 *     @OA\Schema(
 *         type="integer"
 *     )
 * )
 */
class PostRegistrationController extends Controller
{
    /**
     * PostRegistrationController constructor.
     *
     * @param \App\Services\PostRegistrationService $postRegistrationService
     */
    public function __construct(protected PostRegistrationService $postRegistrationService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/postregistrations",
     *     operationId="getPostRegistrationsList",
     *     tags={"PostRegistrations"},
     *     security={{"sanctum": {}}},
     *     summary="Get post registration form data",
     *     description="Returns data submitted by users through the post registration form, which they receive after signing up for an event.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PostRegistration")),
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
            return PostRegistrationResource::collection(PostRegistration::all())->response();
        } else {
            return PostRegistrationResource::collection(
                PostRegistration::WhereHas(
                    'user',
                    function (Builder $query) use (
                        $request
                    ) {
                        $query->where('id', '=', $request->user()->id);
                    }
                )->get()
            )->response();
        }
    }

    /**
     * @OA\Post(
     *     path="/api/postregistrations",
     *     operationId="storePostRegistration",
     *     tags={"PostRegistrations"},
     *     security={{"sanctum": {}}},
     *     summary="Submit a new post restration form",
     *     description="Admins can submit a new post registration form for any user, while users can only submit a new post registration form for themselves.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Post registration details",
     *         @OA\JsonContent(
     *             required={"travelling", "emergency_name", "emergency_phone", "emergency_country", "shirtsize"},
     *             @OA\Property(property="share_acco",        type="string", description="Share accommodation with", example="My friend Bob"),
     *             @OA\Property(property="traveling",         type="string", format="string", description="Where is person travelling from", example="Basel"),
     *             @OA\Property(property="share_travelplans", type="string", maxLength=255, description="How the person is travelling", example="by car"),
     *             @OA\Property(property="emergency_name",    type="string", maxLength=255, description="Emergency Contact", example="John Doe"),
     *             @OA\Property(property="emergency_phone",   type="string", maxLength=255, example="123456789"),
     *             @OA\Property(property="emergency_country", type="string", maxLength=255, example="Switzerland"),
     *             @OA\Property(property="dietprefs",         type="string", maxLength=255, description="Diet preferences / Special needs", example="lactose free"),
     *             @OA\Property(property="shirtsize",         type="string", maxLength=1, description="Size of the shirt", example="L"),
     *             @OA\Property(property="iccmelse",          type="string", maxLength=255,  description="Has visited ICCM before", example="Yes"),
     *             @OA\Property(property="iccmelse_lastyear", type="string", maxLength=255,  description="Year of last ICCM visit", example="2022"),
     *             @OA\Property(property="iccmlocation",      type="string", maxLength=255,  description="Location of last ICCM visit", example="EUROPE"),
     *             @OA\Property(property="knowiccm",          type="string", description="How person found out about ICCM", example="Internet"),
     *             @OA\Property(property="experince_itman",   type="string", description="IT Experience", example="Drupal Developer"),
     *             @OA\Property(property="expert_itman",      type="string", description="Is an expert in", example="Drupal"),
     *             @OA\Property(property="learn_itman",       type="string", description="Wants to learn about", example="Laravel"),
     *             @OA\Property(property="tech_impl",         type="string", description="Plans to implement in coming year", example="Upgrade to Drupal 10"),
     *             @OA\Property(property="new_tech",          type="string", description="Wants to know more about", example="NextJS"),
     *             @OA\Property(property="help_worship",      type="string", description="Wants to join the band", example="Playing piano"),
     *             @OA\Property(property="speakers",          type="string", description="Can share a devotion", example="No, sorry."),
     *             @OA\Property(property="help_iccm",         type="string", description="Can help with ICCM", example="Can help with setup")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PostRegistration")),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        try {
            if ($request->user()->role == 'admin') {
                $form = $this->postRegistrationService->createPostRegistration($data, User::where('id', $data['user'])->first());
            } else {
                $form = $this->postRegistrationService->createPostRegistration($data, $request->user());
            }
        } catch (ValidationException $e) {
            abort(400, $e->getMessage());
        }

        return (new PostRegistrationResource($form))->response();
    }

    /**
     * @OA\Get(
     *     path="/api/postregistration/{id}",
     *     operationId="getPostRegistrationById",
     *     tags={"PostRegistrations"},
     *     security={{"sanctum": {}}},
     *     summary="Get a specific PostRegistration",
     *     description="Only admins can view any PostRegistration, while users can only view their own PostRegistration.",
     *     @OA\Parameter(
     *         ref="#/components/parameters/postregistration_id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PostRegistration")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated, token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, you can only view your own post registration",
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\PostRegistration $postregistration
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, PostRegistration $form): JsonResponse
    {
        if ($request->user()->role == 'admin' || $request->user() == $form->user()) {
            return (new PostRegistrationResource($form))->response();
        } else {
            abort(403, 'You can only view your own post registration');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/postregistrations/{id}",
     *     operationId="updatePostRegistration",
     *     tags={"PostRegistrations"},
     *     security={{"sanctum": {}}},
     *     summary="Update a post restration form submission",
     *     description="Admins can submit a new post registration form for any user, while users can only submit a new post registration form for themselves.",
     *     @OA\Parameter(
     *         ref="#/components/parameters/postregistration_id",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Post registration details",
     *         @OA\JsonContent(
     *             required={},
     *             @OA\Property(property="share_acco",        type="string", description="Share accommodation with", example="My friend Bob"),
     *             @OA\Property(property="traveling",         type="string", format="string", description="Where is person travelling from", example="Basel"),
     *             @OA\Property(property="share_travelplans", type="string", maxLength=255, description="How the person is travelling", example="by car"),
     *             @OA\Property(property="emergency_name",    type="string", maxLength=255, description="Emergency Contact", example="John Doe"),
     *             @OA\Property(property="emergency_phone",   type="string", maxLength=255, example="123456789"),
     *             @OA\Property(property="emergency_country", type="string", maxLength=255, example="Switzerland"),
     *             @OA\Property(property="dietprefs",         type="string", maxLength=255, description="Diet preferences / Special needs", example="lactose free"),
     *             @OA\Property(property="shirtsize",         type="string", maxLength=1, description="Size of the shirt", example="L"),
     *             @OA\Property(property="iccmelse",          type="string", maxLength=255,  description="Has visited ICCM before", example="Yes"),
     *             @OA\Property(property="iccmelse_lastyear", type="string", maxLength=255,  description="Year of last ICCM visit", example="2022"),
     *             @OA\Property(property="iccmlocation",      type="string", maxLength=255,  description="Location of last ICCM visit", example="EUROPE"),
     *             @OA\Property(property="knowiccm",          type="string", description="How person found out about ICCM", example="Internet"),
     *             @OA\Property(property="experince_itman",   type="string", description="IT Experience", example="Drupal Developer"),
     *             @OA\Property(property="expert_itman",      type="string", description="Is an expert in", example="Drupal"),
     *             @OA\Property(property="learn_itman",       type="string", description="Wants to learn about", example="Laravel"),
     *             @OA\Property(property="tech_impl",         type="string", description="Plans to implement in coming year", example="Upgrade to Drupal 10"),
     *             @OA\Property(property="new_tech",          type="string", description="Wants to know more about", example="NextJS"),
     *             @OA\Property(property="help_worship",      type="string", description="Wants to join the band", example="Playing piano"),
     *             @OA\Property(property="speakers",          type="string", description="Can share a devotion", example="No, sorry."),
     *             @OA\Property(property="help_iccm",         type="string", description="Can help with ICCM", example="Can help with setup")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PostRegistration")),
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
     * @OA\Put(
     *     path="/api/postregistrations/{id}",
     *     operationId="replacePostRegistration",
     *     tags={"PostRegistrations"},
     *     security={{"sanctum": {}}},
     *     summary="Replace a post restration form submission",
     *     description="Admins can submit a new post registration form for any user, while users can only submit a new post registration form for themselves.",
     *     @OA\Parameter(
     *         ref="#/components/parameters/postregistration_id",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Post registration details",
     *         @OA\JsonContent(
     *             required={"travelling", "emergency_name", "emergency_phone", "emergency_country", "shirtsize"},
     *             @OA\Property(property="share_acco",        type="string", description="Share accommodation with", example="My friend Bob"),
     *             @OA\Property(property="traveling",         type="string", format="string", description="Where is person travelling from", example="Basel"),
     *             @OA\Property(property="share_travelplans", type="string", maxLength=255, description="How the person is travelling", example="by car"),
     *             @OA\Property(property="emergency_name",    type="string", maxLength=255, description="Emergency Contact", example="John Doe"),
     *             @OA\Property(property="emergency_phone",   type="string", maxLength=255, example="123456789"),
     *             @OA\Property(property="emergency_country", type="string", maxLength=255, example="Switzerland"),
     *             @OA\Property(property="dietprefs",         type="string", maxLength=255, description="Diet preferences / Special needs", example="lactose free"),
     *             @OA\Property(property="shirtsize",         type="string", maxLength=1, description="Size of the shirt", example="L"),
     *             @OA\Property(property="iccmelse",          type="string", maxLength=255,  description="Has visited ICCM before", example="Yes"),
     *             @OA\Property(property="iccmelse_lastyear", type="string", maxLength=255,  description="Year of last ICCM visit", example="2022"),
     *             @OA\Property(property="iccmlocation",      type="string", maxLength=255,  description="Location of last ICCM visit", example="EUROPE"),
     *             @OA\Property(property="knowiccm",          type="string", description="How person found out about ICCM", example="Internet"),
     *             @OA\Property(property="experince_itman",   type="string", description="IT Experience", example="Drupal Developer"),
     *             @OA\Property(property="expert_itman",      type="string", description="Is an expert in", example="Drupal"),
     *             @OA\Property(property="learn_itman",       type="string", description="Wants to learn about", example="Laravel"),
     *             @OA\Property(property="tech_impl",         type="string", description="Plans to implement in coming year", example="Upgrade to Drupal 10"),
     *             @OA\Property(property="new_tech",          type="string", description="Wants to know more about", example="NextJS"),
     *             @OA\Property(property="help_worship",      type="string", description="Wants to join the band", example="Playing piano"),
     *             @OA\Property(property="speakers",          type="string", description="Can share a devotion", example="No, sorry."),
     *             @OA\Property(property="help_iccm",         type="string", description="Can help with ICCM", example="Can help with setup")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PostRegistration")),
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
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\PostRegistration $postregistration
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, PostRegistration $form)
    {
        var_dump($form->user());
        if ($request->user()->role == 'admin' || $request->user() == $form->user()) {
            $date = $this->postRegistrationService->validateOnUpdate($request->all());
            $form->update($date);

            return (new PostRegistrationResource($form))->response();
        } else {
            abort(403, 'You can only edit your own post registration');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/postregistration/{id}",
     *     operationId="deletePostRegistration",
     *     tags={"PostRegistrations"},
     *     security={{"sanctum": {}}},
     *     summary="Delete post registration",
     *     description="Only admins can delete post registrations.",
     *     @OA\Parameter(
     *         ref="#/components/parameters/postregistration_id",
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
     *         description="Forbidden, you can not delete your post registration submission",
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\PostRegistration $postregistration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PostRegistration $postregistration): \Illuminate\Http\Response
    {
        if ($request->user()->role == 'admin') {
            $postregistration->delete();

            return response(null, 204);
        } else {
            abort(403, 'You can not delete your post registration submission');
        }
    }
}
