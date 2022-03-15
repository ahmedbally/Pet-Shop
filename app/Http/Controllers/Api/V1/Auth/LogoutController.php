<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request.
     *
     * @OA\Get(
     * path="/api/v1/user/logout",
     * operationId="Logout",
     * security={{"bearer_token": {}}},
     * tags={"User"},
     * summary="User Logout",
     * description="User Logout here",
     *      @OA\Response(
     *          response=200,
     *          description="User logged out successfully."
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        Auth::logout();

        return JsonResource::make([])->success()->response();
    }
}
