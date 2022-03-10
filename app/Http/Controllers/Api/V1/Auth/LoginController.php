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
            ]
        ]);

        if (! $token = Auth::attempt($credentials)) {
            throw new UnprocessableEntityHttpException('Failed to authenticate user');
        }
        event(new Login(Auth::user()));
        return JsonResource::make(['token' => $token])->success()->response();
    }
}
