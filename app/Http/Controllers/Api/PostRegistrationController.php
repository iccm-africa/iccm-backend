<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostRegistrationResource;
use App\Models\PostRegistration;
use App\Models\User;
use App\Services\PostRegistrationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

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
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        if ($request->user()->role == 'admin') {
            $form = $this->postRegistrationService->createPostRegistration($data, User::where('id', $data['user'])->first());
        } else {
            $form = $this->postRegistrationService->createPostRegistration($data, $request->user());
        }

        return (new PostRegistrationResource($form))->response();
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
