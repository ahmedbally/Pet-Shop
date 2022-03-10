<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use \Illuminate\Support\Facades\Password as PasswordBroker;
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
            'email' => ['required','email'],
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
