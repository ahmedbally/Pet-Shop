<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Middleware\Authenticate;
use App\Models\Brand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class BrandControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\BrandController
 */
class BrandControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authenticate::class);
    }

    public function test_index(): void
    {
        $this->getJson(route('brands'))
            ->assertStatus(200);
    }

    public function test_store(): void
    {
        $this->postJson(route('brand.create'), [
            'title' => 'test brand',
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.title', 'test brand') ;
    }

    public function test_show(): void
    {
        $brand = Brand::factory()->create();
        $this->getJson(route('brand.show',$brand->uuid))
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', $brand->uuid);
    }

    public function test_update(): void
    {
        $brand = Brand::factory()->create();
        $this->putJson(route('brand.edit', $brand->uuid), [
            'title' => 'test new title',
        ])
            ->assertStatus(200)
            ->assertJsonPath('data.title', 'test new title');
    }

    public function testDestroy(): void
    {
        $brand = Brand::factory()->create();
        $this->deleteJson(route('brand.delete', $brand->uuid))
            ->assertStatus(200);
    }
}
