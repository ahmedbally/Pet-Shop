<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

/**
 * Class JsonResourceTest.
 *
 * @covers \App\Http\Resources\JsonResource
 */
class JsonResourceTest extends TestCase
{
    /**
     * @var JsonResource
     */
    protected $jsonResource;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->jsonResource = JsonResource::make([]);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->jsonResource);
    }

    public function test_to_array(): void
    {
        $request = Mockery::mock(Request::class);

        $this->assertSame([], $this->jsonResource->toArray($request));
    }

    public function test_with(): void
    {
        $request = Mockery::mock(Request::class);

        $this->assertSame([
            'success' => 1,
            'error' => null,
            'errors' => [],
            'extra' => [],
        ], $this->jsonResource->with($request));
    }

    public function test_success(): void
    {
        $request = Mockery::mock(Request::class);

        $this->assertSame([
            'success' => 1,
            'error' => null,
            'errors' => [],
            'extra' => [],
        ], $this->jsonResource->success()->with($request));
    }

    public function test_error(): void
    {
        $request = Mockery::mock(Request::class);

        $this->assertSame([
            'success' => 0,
            'error' => 'test',
            'errors' => [],
            'trace' => [],
        ], $this->jsonResource->error('test')->with($request));
    }

    public function test_errors(): void
    {
        $request = Mockery::mock(Request::class);

        $this->assertSame([
            'success' => 0,
            'error' => 'test',
            'errors' => ['error'],
            'trace' => [],
        ], $this->jsonResource->error('test')->errors(['error'])->with($request));
    }

    public function test_trace(): void
    {
        $request = Mockery::mock(Request::class);

        $this->assertSame([
            'success' => 0,
            'error' => 'test',
            'errors' => [],
            'trace' => ['trace'],
        ], $this->jsonResource->error('test')->trace(['trace'])->with($request));
    }

    public function test_status(): void
    {
        $this->assertEquals(400, $this->jsonResource->status(400)->response()->getStatusCode());
    }

    public function test_headers(): void
    {
        $this->assertArrayHasKey('x-test-header', $this->jsonResource->headers(['x-test-header' => 'test'])->response()->headers->all());
    }
}
