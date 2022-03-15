<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

/**
 * Class BrandResourceTest.
 *
 * @covers \App\Http\Resources\BrandResource
 */
class BrandResourceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var BrandResource
     */
    protected $brandResource;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $brand = Brand::factory()->create();
        $this->brandResource = BrandResource::make($brand);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->brandResource);
    }

    public function test_to_array(): void
    {
        $request = Mockery::mock(Request::class);
        $keys = ['uuid', 'title', 'slug', 'created_at', 'updated_at'];
        $resource = $this->brandResource->toArray($request);
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $resource);
        }
    }
}
