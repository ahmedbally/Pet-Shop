<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Middleware\Authenticate;
use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class ProductControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\ProductController
 */
class ProductControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authenticate::class);
    }

    public function test_index(): void
    {
        $this->getJson(route('products'))
            ->assertStatus(200);
    }

    public function test_store(): void
    {
        $category = Category::all()->random();
        $brand = Brand::all()->random();
        $image = File::all()->random();
        $this->postJson(route('product.create'), [
            'title' => 'test product',
            'price' => $this->faker->randomFloat(2, 20, 3000),
            'description' => $this->faker->text,
            'brand' => $brand->uuid,
            'image' => $image->uuid,
            'category_uuid' => $category->uuid,
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.title', 'test product');
    }

    public function test_show(): void
    {
        $product = Product::factory()->create();
        $this->getJson(route('product.show', $product->uuid))
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', $product->uuid);
    }

    public function test_update(): void
    {
        $category = Category::all()->random();
        $brand = Brand::all()->random();
        $image = File::all()->random();
        $product = Product::factory()->create();
        $this->putJson(route('product.edit', $product->uuid), [
            'title' => 'test new title',
            'price' => $this->faker->randomFloat(2, 20, 3000),
            'description' => $this->faker->text,
            'brand' => $brand->uuid,
            'image' => $image->uuid,
            'category_uuid' => $category->uuid,
        ])
            ->assertStatus(200)
            ->assertJsonPath('data.title', 'test new title');
    }

    public function testDestroy(): void
    {
        $product = Product::factory()->create();
        $this->deleteJson(route('product.delete', $product->uuid))
            ->assertStatus(200);
    }
}
