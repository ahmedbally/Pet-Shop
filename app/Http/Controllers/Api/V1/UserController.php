<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\JsonResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ValidatedInput;

class UserController extends Controller
{
    /**
     * @var User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     * path="/api/v1/user/create",
     * operationId="Register",
     * tags={"User"},
     * summary="User Register",
     * description="User Register here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"first_name", "last_name", "email", "password", "password_confirmation", "address", "phone_number"},
     *               @OA\Property(property="first_name", type="text"),
     *               @OA\Property(property="last_name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirmation", type="password"),
     *               @OA\Property(property="avatar", type="text"),
     *               @OA\Property(property="address", type="text"),
     *               @OA\Property(property="phone_number", type="text"),
     *               @OA\Property(property="is_marketing", type="boolean"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Registration Successful"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        /**
         * @var ValidatedInput $safeRequest
         */
        $safeRequest = $request->safe();
        $user = User::create($safeRequest->all());

        return UserResource::make($user)->success()->response();
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     * path="/api/v1/user",
     * operationId="profile",
     * security={{"bearer_token": {}}},
     * tags={"User"},
     * summary="Display User Profile",
     * description="View user profile single",
     *      @OA\Response(
     *          response=200,
     *          description="User profile displayed successfully"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return UserResource::make($this->user)->success()->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     * path="/api/v1/user/edit",
     * operationId="Edit",
     * security={{"bearer_token": {}}},
     * tags={"User"},
     * summary="Update  user profile",
     * description="User Update profile",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"first_name", "last_name", "email", "password", "password_confirmation", "address", "phone_number"},
     *               @OA\Property(property="first_name", type="text"),
     *               @OA\Property(property="last_name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirmation", type="password"),
     *               @OA\Property(property="avatar", type="text"),
     *               @OA\Property(property="address", type="text"),
     *               @OA\Property(property="phone_number", type="text"),
     *               @OA\Property(property="is_marketing", type="boolean"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Profile Updated Successfully"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request)
    {
        /**
         * @var ValidatedInput $safeRequest
         */
        $safeRequest = $request->safe();
        optional($this->user)->update($safeRequest->all());

        return UserResource::make($this->user)->success()->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     * path="/api/v1/user",
     * operationId="DeleteUser",
     * security={{"bearer_token": {}}},
     * tags={"User"},
     * summary="User delete account",
     * description="User delete account",
     *      @OA\Response(
     *          response=200,
     *          description="User deleted successfully."
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        if (! optional($this->user)->delete()) {
            return JsonResource::make([])->error('Unable to delete')->status(403)->response();
        }

        return JsonResource::make([])->success()->status(200)->response();
    }
}
