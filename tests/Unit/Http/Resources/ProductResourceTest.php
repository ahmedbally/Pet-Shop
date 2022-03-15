<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

/**
 * Class ProductResourceTest.
 *
 * @covers \App\Http\Resources\ProductResource
 */
class ProductResourceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var ProductResource
     */
    protected $productResource;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $product = Product::factory()->create();
        $this->productResource = ProductResource::make($product);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->productResource);
    }

    public function testToArray(): void
    {
        $request = Mockery::mock(Request::class);
        $keys = [
            'title',
            'category_uuid',
            'price',
            'description',
            'metadata',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
        $resource = $this->productResource->toArray($request);
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $resource);
        }
    }
}
