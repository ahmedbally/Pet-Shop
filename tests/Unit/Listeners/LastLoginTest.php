<?php

namespace Tests\Unit\Listeners;

use App\Events\Login;
use App\Listeners\LastLogin;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

/**
 * Class LastLoginTest.
 *
 * @covers \App\Listeners\LastLogin
 */
class LastLoginTest extends TestCase
{
    /**
     * @var LastLogin
     */
    protected $lastLogin;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->lastLogin = new LastLogin();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->lastLogin);
    }

    public function test_handle(): void
    {
        $user = User::factory()->create();

        $event = Mockery::mock(Login::class, [$user]);

        $this->lastLogin->handle($event);

        $this->assertNotNull($user->last_login_at);
    }

    public function test_listener_is_attached(): void
    {
        Event::fake();
        Event::assertListening(
            Login::class,
            LastLogin::class
        );
    }
}
