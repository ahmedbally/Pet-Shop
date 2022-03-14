<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as PasswordBroker;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ResetPasswordController extends Controller
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
        $credentials = $request->validate([
            'email' => ['required'],
            'token' => ['required','string'],
            'password' => Password::min(8)->rules('confirmed')
        ]);

        $status = PasswordBroker::reset($credentials, function ($user, $password) {
            $user->update(['password' => Hash::make($password)]);
        });

        if ($status === PasswordBroker::PASSWORD_RESET) {
            return JsonResource::make([
                'message' => 'Password has been successfully updated'
                ])->success()->response();
        }

        throw new UnprocessableEntityHttpException('Invalid or expired token');
    }
}
