<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\UserController;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class UserControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\UserController
 */
class UserControllerTest extends TestCase
{
    use WithFaker;
    public function test_store(): void
    {
        $password = $this->faker->password(8);
        $avatar = File::factory()->create();
        $this->postJson(route('user.create'), [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password,
            'avatar' => $avatar->uuid,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->e164PhoneNumber,
            'is_marketing' => $this->faker->boolean,
        ])
            ->assertStatus(201);
    }

    public function test_show(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->getJson(route('user.show'))
            ->assertStatus(200);
    }

    public function test_update(): void
    {
        $user = User::factory()->create();
        $password = $this->faker->password(8);
        $avatar = File::factory()->create();
        $this->actingAs($user)->putJson(route('user.edit'), [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password,
            'avatar' => $avatar->uuid,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->e164PhoneNumber,
            'is_marketing' => $this->faker->boolean,
        ])
            ->assertStatus(200);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->deleteJson(route('user.delete'))
            ->assertStatus(202);
    }
}
