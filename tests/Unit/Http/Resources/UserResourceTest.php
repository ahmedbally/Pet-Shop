<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

/**
 * Class UserResourceTest.
 *
 * @covers \App\Http\Resources\UserResource
 */
class UserResourceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var UserResource
     */
    protected $userResource;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->userResource = UserResource::make($user);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->userResource);
    }

    public function test_to_array(): void
    {
        $request = Mockery::mock(Request::class);
        $keys = ['first_name',
            'last_name',
            'email',
            'avatar',
            'address',
            'phone_number',
            'is_marketing',
            'last_login_at', ];
        $resource = $this->userResource->toArray($request);
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $resource);
        }
    }
}
