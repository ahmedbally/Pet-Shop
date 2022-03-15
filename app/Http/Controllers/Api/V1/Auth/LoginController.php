<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Events\Login;
use App\Http\Controllers\Controller;
use App\Http\Resources\JsonResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class LoginController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle the incoming request.
     *
     * @OA\Post(
     * path="/api/v1/user/login",
     * operationId="Login",
     * tags={"User"},
     * summary="User Login",
     * description="User Login here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="password"),
     *               @OA\Property(property="password", type="password"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        if (! $token = Auth::attempt($credentials)) {
            throw new UnprocessableEntityHttpException('Failed to authenticate user');
        }
        event(new Login(Auth::user()));

        return JsonResource::make(['token' => $token])->success()->response();
    }
}
