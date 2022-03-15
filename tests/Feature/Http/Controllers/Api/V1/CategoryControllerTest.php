<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Http\Middleware\Authenticate;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class CategoryControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\CategoryController
 */
class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authenticate::class);
    }

    public function test_index(): void
    {
        $this->getJson(route('categories'))
            ->assertStatus(200);
    }

    public function test_store(): void
    {
        $this->postJson(route('category.create'), [
            'title' => 'test category',
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.title', 'test category');
    }

    public function test_show(): void
    {
        $category = Category::factory()->create();
        $this->getJson(route('category.show', $category->uuid))
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', $category->uuid);
    }

    public function test_update(): void
    {
        $category = Category::factory()->create();
        $this->putJson(route('category.edit', $category->uuid), [
            'title' => 'test new title',
        ])
            ->assertStatus(200)
            ->assertJsonPath('data.title', 'test new title');
    }

    public function testDestroy(): void
    {
        $category = Category::factory()->create();
        $this->deleteJson(route('category.delete', $category->uuid))
            ->assertStatus(200);
    }
}
