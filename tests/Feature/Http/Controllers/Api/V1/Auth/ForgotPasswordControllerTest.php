<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Models\User;
use Tests\TestCase;

/**
 * Class ForgotPasswordControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\Auth\ForgotPasswordController
 */
class ForgotPasswordControllerTest extends TestCase
{
    public function test__invoke(): void
    {
        $user = User::factory()->create();

        $this->postJson(route('user.forgot-password'),
        [
            'email' => $user->email,
        ])
            ->assertStatus(200)
            ->assertJsonStructure(['data'=>['reset_token']]);
    }

    public function test_validation(): void
    {
        $this->postJson(route('user.forgot-password'))
            ->assertStatus(422)
            ->assertJsonValidationErrors('email', 'errors');
    }
}
