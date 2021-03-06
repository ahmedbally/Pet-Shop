<?php

namespace Tests\Unit\Traits;

use App\Models\User;
use App\Traits\Uuidable;
use Tests\TestCase;

/**
 * Class UuidableTest.
 *
 * @covers \App\Traits\Uuidable
 */
class UuidableTest extends TestCase
{
    /**
     * @var Uuidable
     */
    protected $uuidable;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->uuidable = $this->getMockBuilder(Uuidable::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->uuidable);
    }

    public function testGetIncrementing(): void
    {
        $this->assertFalse($this->uuidable->getIncrementing());
    }

    public function test_get_key_name(): void
    {
        $this->assertEquals($this->uuidable->uuidColumn, $this->uuidable->getKeyName());
    }

    public function test_get_key_type(): void
    {
        $this->assertEquals('string', $this->uuidable->getKeyType());
    }

    public function test_create(): void
    {
        $user = User::factory()->create();
        $this->assertNotNull($user->uuid);
    }
}
