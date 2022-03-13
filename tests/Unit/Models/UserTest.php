<?php

namespace Tests\Unit\Models;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Class UserTest.
 *
 * @covers \App\Models\User
 */
class UserTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->user = new User();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->user);
    }

    public function test_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id',
                'uuid',
                'first_name',
                'last_name',
                'is_admin',
                'email',
                'password',
                'avatar',
                'address',
                'phone_number',
                'is_marketing',
                'created_at',
                'updated_at',
                'last_login_at',
            ]));
    }

    public function test_get_jwt_identifier(): void
    {
        $this->assertEquals($this->user->getKey(), $this->user->getJWTIdentifier());
    }

    public function test_get_jwt_custom_claims(): void
    {
        $this->assertEquals([],$this->user->getJWTCustomClaims());
    }

    public function test_avatar(): void
    {
        $file = File::factory()->create();
        $user = $this->user->factory()
            ->create(['avatar'=>$file->uuid]);

        $this->assertInstanceOf(File::class, $user->avatar()->first());
        $this->assertEquals(1, $user->avatar()->count());
    }
}
