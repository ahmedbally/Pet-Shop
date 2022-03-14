<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Class FileControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\FileController
 */
class LogoutControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_logout(): void
    {
        $token = Auth::tokenById(User::factory()->create()->uuid);

        $this->getJson(route('user.logout'), [
            'Authorization' => 'Bearer '.$token,
        ])->assertStatus(200);

        $this->getJson(route('user.logout'))->assertStatus(401);
    }
}
