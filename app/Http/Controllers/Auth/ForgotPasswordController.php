<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\JsonResource;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Password as PasswordBroker;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ForgotPasswordController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $newToken = null;

        $credentials = $request->validate(['email' => ['required','email']]);

        $status = PasswordBroker::sendResetLink($credentials, function ($user, $token) use (&$newToken){
            $newToken = $token;
        });

        if ($status === PasswordBroker::RESET_LINK_SENT){
            return JsonResource::make([
                'reset_token' => $newToken
            ])->success()->response();
        }

        throw new UnprocessableEntityHttpException('Invalid email');
    }
}
