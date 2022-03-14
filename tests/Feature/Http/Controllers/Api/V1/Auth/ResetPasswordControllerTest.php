<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Class ResetPasswordControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\Auth\ResetPasswordController
 */
class ResetPasswordControllerTest extends TestCase
{
    public function test__invoke(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('user.forgot-password'),
            [
                'email' => $user->email,
            ]);

        $newPassword = Str::random(18);
        $this->postJson(route('user.reset-password'),[
            'email' => $user->email,
            'token' => $response->json('data.reset_token'),
            'password' =>  $newPassword,
            'password_confirmation' =>  $newPassword,
        ])
            ->assertStatus(200);
    }

    public function test_validation(): void
    {
        $this->postJson(route('user.reset-password'),[
            'email' => null,
            'token' => null,
            'password' =>  null,
            'password_confirmation' =>  null,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email','token','password'], 'errors');
    }
}
