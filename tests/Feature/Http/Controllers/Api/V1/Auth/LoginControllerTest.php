<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Auth;

use App\Events\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Class FileControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\FileController
 */
class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => Hash::make('12345678'),
        ]);
    }

    public function test_login(): void
    {
        Event::fake();

        $this->postJson(route('user.login'), [
            'email' => $this->user->email,
            'password' => '12345678',
        ])->assertStatus(200)
            ->assertJsonStructure(['data'=> ['token']]);

        Event::assertDispatched(Login::class);
    }

    public function test_login_validation(): void
    {
        $this->postJson(route('user.login'), [
            'email' => 'test@test.com',
            'password' => '12345678',
        ])->assertStatus(422)
            ->assertJsonPath('error', 'Failed to authenticate user');

        $this->postJson(route('user.login'), [
            'email' => 'test',
            'password' => '12345678',
        ])->assertStatus(422)
            ->assertJsonValidationErrorFor('email');

        $this->postJson(route('user.login'), [
            'email' => 'test@test.com',
            'password' => null,
        ])->assertStatus(422)
            ->assertJsonValidationErrorFor('password');
    }
}
