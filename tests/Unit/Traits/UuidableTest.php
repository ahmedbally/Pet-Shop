<?php

namespace Tests\Unit\Traits;

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
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->uuidable = $this->getMockBuilder(Uuidable::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
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

    public function testGetKeyName(): void
    {
        $this->assertEquals($this->uuidable->uuidColumn, $this->uuidable->getKeyName());
    }

    public function testGetKeyType(): void
    {
        $this->assertEquals('string', $this->uuidable->getKeyType());
    }
}
